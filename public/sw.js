'use strict';

const CACHE_VERSION = 'pringanom-pwa-v1';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const OFFLINE_URL = '/offline.html';
const PRECACHE = [
    OFFLINE_URL,
    '/manifest.json',
    '/js/offline-db.js',
    '/js/offline-sync.js',
    '/images/pwa-icon-192.png',
    '/images/pwa-icon-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(STATIC_CACHE).then((cache) => cache.addAll(PRECACHE)));
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((key) => key.startsWith('pringanom-pwa-') && key !== STATIC_CACHE).map((key) => caches.delete(key))))
            .then(() => self.clients.claim()),
    );
});

async function staleWhileRevalidate(request) {
    const cache = await caches.open(STATIC_CACHE);
    const cached = await cache.match(request);
    const network = fetch(request).then((response) => {
        if (response.ok || response.type === 'opaque') cache.put(request, response.clone());
        return response;
    }).catch(() => cached);
    return cached || network;
}

async function networkFirstNavigation(request) {
    try {
        return await fetch(request);
    } catch (_) {
        return (await caches.match(OFFLINE_URL)) || Response.error();
    }
}

self.addEventListener('fetch', (event) => {
    const request = event.request;
    if (request.method !== 'GET') return;

    const url = new URL(request.url);
    if (request.mode === 'navigate') {
        event.respondWith(networkFirstNavigation(request));
        return;
    }

    if (['style', 'script', 'image', 'font'].includes(request.destination) || /\.(?:css|js|png|jpe?g|gif|svg|webp|woff2?|ttf|otf)$/i.test(url.pathname)) {
        event.respondWith(staleWhileRevalidate(request));
    }
});

async function notifyClientsToSync() {
    const clients = await self.clients.matchAll({ type: 'window', includeUncontrolled: true });
    clients.forEach((client) => client.postMessage({ type: 'SYNC_PENDING_UMKMS' }));
}

function openOfflineDatabase() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('PringanomOfflineDB', 1);
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function readPendingUmkms() {
    const database = await openOfflineDatabase();
    return new Promise((resolve, reject) => {
        if (!database.objectStoreNames.contains('pending_umkms')) {
            database.close();
            resolve([]);
            return;
        }
        const transaction = database.transaction('pending_umkms', 'readonly');
        const request = transaction.objectStore('pending_umkms').getAll();
        request.onsuccess = () => resolve(request.result.filter((row) => row.status_sync === false));
        request.onerror = () => reject(request.error);
        transaction.oncomplete = () => database.close();
    });
}

async function removeSyncedUmkms(ids) {
    const database = await openOfflineDatabase();
    return new Promise((resolve, reject) => {
        const transaction = database.transaction('pending_umkms', 'readwrite');
        const store = transaction.objectStore('pending_umkms');
        ids.forEach((id) => store.delete(id));
        transaction.oncomplete = () => { database.close(); resolve(); };
        transaction.onerror = () => { database.close(); reject(transaction.error); };
    });
}

async function syncPendingUmkmsFromWorker() {
    const pending = await readPendingUmkms();
    if (pending.length === 0) return;

    const csrfToken = pending.find((item) => item._csrf_token)?._csrf_token;
    if (!csrfToken) throw new Error('Token CSRF antrean offline tidak tersedia.');

    const response = await fetch('/api/umkm/sync-offline', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ items: pending }),
    });

    if (!response.ok || response.redirected) throw new Error(`Sinkronisasi gagal dengan status ${response.status}.`);
    const result = await response.json();
    if (!result.success) throw new Error('Server menolak sinkronisasi.');

    await removeSyncedUmkms(result.synced_ids || []);
    const clients = await self.clients.matchAll({ type: 'window', includeUncontrolled: true });
    clients.forEach((client) => client.postMessage({
        type: 'UMKM_SYNC_COMPLETE',
        synced_count: result.synced_count,
        synced_ids: result.synced_ids,
    }));
}

self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-pending-umkms') event.waitUntil(syncPendingUmkmsFromWorker());
});

self.addEventListener('message', (event) => {
    if (event.data?.type === 'REGISTER_UMKM_SYNC' && self.registration.sync) {
        event.waitUntil(self.registration.sync.register('sync-pending-umkms'));
    }
    if (event.data?.type === 'TRIGGER_UMKM_SYNC') event.waitUntil(syncPendingUmkmsFromWorker().catch(() => notifyClientsToSync()));
});