(function (scope) {
    'use strict';

    const DB_NAME = 'PringanomOfflineDB';
    const DB_VERSION = 1;
    const STORE_NAME = 'pending_umkms';

    function openDatabase() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(DB_NAME, DB_VERSION);

            request.onupgradeneeded = () => {
                const database = request.result;
                if (!database.objectStoreNames.contains(STORE_NAME)) {
                    const store = database.createObjectStore(STORE_NAME, { keyPath: 'id' });
                    store.createIndex('status_sync', 'status_sync', { unique: false });
                }
            };
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    function transaction(mode, operation) {
        return openDatabase().then((database) => new Promise((resolve, reject) => {
            const tx = database.transaction(STORE_NAME, mode);
            const store = tx.objectStore(STORE_NAME);
            let result;

            try {
                result = operation(store);
            } catch (error) {
                database.close();
                reject(error);
                return;
            }

            tx.oncomplete = () => { database.close(); resolve(result); };
            tx.onerror = () => { database.close(); reject(tx.error); };
            tx.onabort = () => { database.close(); reject(tx.error); };
        }));
    }

    function createId() {
        return scope.crypto?.randomUUID?.() || `${Date.now()}-${Math.random().toString(16).slice(2)}`;
    }

    scope.saveUmkmOffline = function saveUmkmOffline(payload) {
        const row = {
            id: payload.id || createId(),
            nama_usaha: payload.nama_usaha || '',
            pemilik: payload.pemilik || '',
            dukuh: payload.dukuh || '',
            alamat_lengkap: payload.alamat_lengkap || '',
            bentuk_usaha: payload.bentuk_usaha || '',
            jenis_usaha: payload.jenis_usaha || '',
            no_hp: payload.no_hp || '',
            created_at_offline: payload.created_at_offline || new Date().toISOString(),
            status_sync: false,
            _csrf_token: payload._csrf_token || document.querySelector('meta[name="csrf-token"]')?.content || '',
        };

        return transaction('readwrite', (store) => store.put(row)).then(() => row.id);
    };

    scope.getPendingUmkms = function getPendingUmkms() {
        return transaction('readonly', (store) => new Promise((resolve, reject) => {
            const request = store.getAll();
            request.onsuccess = () => resolve(request.result.filter((row) => row.status_sync === false));
            request.onerror = () => reject(request.error);
        })).then((requestResult) => requestResult);
    };

    scope.removeSyncedUmkms = function removeSyncedUmkms(ids) {
        const uniqueIds = [...new Set(ids || [])];
        return transaction('readwrite', (store) => uniqueIds.forEach((id) => store.delete(id)));
    };

    scope.countPendingUmkms = function countPendingUmkms() {
        return scope.getPendingUmkms().then((rows) => rows.length);
    };
})(globalThis);