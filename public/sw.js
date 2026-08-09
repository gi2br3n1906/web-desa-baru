'use strict';

const CACHE_VERSION = 'pringanom-pwa-v4';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const OFFLINE_URL = '/offline.html';
const PUBLIC_PAGE_URLS = [
    '/',
    '/pembukuan',
    '/umkm',
    '/posyandu',
    '/profil',
    '/layanan',
    '/berita',
];
const PUBLIC_PAGE_PATHS = new Set(PUBLIC_PAGE_URLS);
const PRECACHE_URLS = [
    OFFLINE_URL,
    '/manifest.json',
    '/js/offline-db.js',
    '/js/offline-sync.js',
    '/images/pwa-icon-192.png',
    '/images/pwa-icon-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil((async () => {
        const cache = await caches.open(STATIC_CACHE);

        // Core offline shell must succeed. Dynamic public pages are cached
        // independently so one temporary 5xx response cannot abort install.
        await cache.addAll(PRECACHE_URLS);
        await Promise.allSettled(PUBLIC_PAGE_URLS.map((url) => cache.add(new Request(url, {
            credentials: 'omit',
        }))));
        await self.skipWaiting();
    })());
});

self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        const keys = await caches.keys();
        await Promise.all(keys
            .filter((key) => key.startsWith('pringanom-pwa-') && key !== STATIC_CACHE)
            .map((key) => caches.delete(key)));
        await self.clients.claim();
    })());
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

function normalizedNavigationRequests(request) {
    const url = new URL(request.url);
    url.search = '';

    const normalizedPath = url.pathname === '/' ? '/' : url.pathname.replace(/\/+$/, '');
    const alternatePath = normalizedPath === '/' ? '/' : `${normalizedPath}/`;

    return [
        request,
        new Request(`${url.origin}${normalizedPath}`, { method: 'GET' }),
        new Request(`${url.origin}${alternatePath}`, { method: 'GET' }),
    ];
}

function normalizedPublicPath(request) {
    const url = new URL(request.url);
    return url.pathname === '/' ? '/' : url.pathname.replace(/\/+$/, '');
}

async function cacheSuccessfulPublicNavigation(request, response) {
    if (!response?.ok || ['opaque', 'error'].includes(response.type)) return;

    const normalizedPath = normalizedPublicPath(request);
    if (!PUBLIC_PAGE_PATHS.has(normalizedPath)) return;

    try {
        const cache = await caches.open(STATIC_CACHE);
        const normalizedUrl = new URL(normalizedPath, self.location.origin).toString();
        const guestRequest = new Request(normalizedUrl, {
            method: 'GET',
            credentials: 'omit',
            headers: { 'Accept': 'text/html' },
        });
        const guestResponse = await fetch(guestRequest);
        if (guestResponse.ok && !['opaque', 'error'].includes(guestResponse.type)) {
            await cache.put(guestRequest, guestResponse);
        }
    } catch (_) {
        // A successful online navigation must still render even if runtime
        // cache persistence is unavailable in a restricted browser context.
    }
}

async function cachedNavigationResponse(request) {
    for (const candidate of normalizedNavigationRequests(request)) {
        try {
            const response = await caches.match(candidate, { ignoreSearch: true });
            if (response) return response;
        } catch (_) {
            // Continue to the guaranteed offline response when Cache API fails.
        }
    }

    return null;
}

function emergencyOfflineResponse() {
    return new Response(
        '<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Mode Offline | Desa Pringanom</title></head><body style="margin:0;min-height:100vh;display:grid;place-items:center;background:#0f172a;color:#e2e8f0;font-family:system-ui,sans-serif;padding:24px"><main><h1>Portal Desa sedang offline</h1><p>Periksa koneksi Anda lalu coba kembali.</p></main></body></html>',
        { status: 200, headers: { 'Content-Type': 'text/html; charset=utf-8' } },
    );
}

async function networkFirstNavigation(request) {
    try {
        const networkResponse = await fetch(request);
        await cacheSuccessfulPublicNavigation(request, networkResponse);
        return networkResponse;
    } catch (_) {
        try {
            const cachedPage = await cachedNavigationResponse(request);
            if (cachedPage) return cachedPage;
        } catch (_) {
            // URL normalization or Cache API may fail in restricted contexts.
        }

        try {
            const offlinePage = await caches.match(OFFLINE_URL, { ignoreSearch: true });
            if (offlinePage) return offlinePage;
        } catch (_) {
            // Continue to the next guaranteed fallback.
        }

        try {
            const cachedHome = await caches.match('/', { ignoreSearch: true });
            if (cachedHome) return cachedHome;
        } catch (_) {
            // The inline emergency response below does not depend on Cache API.
        }

        return emergencyOfflineResponse();
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