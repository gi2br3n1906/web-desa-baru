(function () {
    'use strict';

    const SYNC_ENDPOINT = '/api/umkm/sync-offline';
    const OFFLINE_MESSAGE = '⚠️ Mode Offline Terdeteksi: Data UMKM tersimpan di memori perangkat lokal. Data akan otomatis dikirim ke server saat Anda terhubung kembali ke internet.';
    let syncInProgress = false;

    function showToast(message, color = 'blue') {
        let container = document.querySelector('[data-pwa-toast-container]');
        if (!container) {
            container = document.createElement('div');
            container.dataset.pwaToastContainer = '';
            container.className = 'fixed right-4 top-20 z-[100] flex w-[min(28rem,calc(100vw-2rem))] flex-col gap-3';
            document.body.appendChild(container);
        }

        const colors = {
            amber: 'border-amber-300 bg-amber-50 text-amber-950',
            blue: 'border-blue-300 bg-blue-50 text-blue-950',
            green: 'border-green-300 bg-green-50 text-green-950',
            red: 'border-red-300 bg-red-50 text-red-950',
        };
        const toast = document.createElement('div');
        toast.className = `rounded-xl border p-4 text-sm font-semibold leading-6 shadow-xl ${colors[color] || colors.blue}`;
        toast.textContent = message;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 8000);
    }

    async function updateIndicators() {
        const online = navigator.onLine;
        let count = 0;
        try { count = await window.countPendingUmkms(); } catch (_) { /* IndexedDB may be unavailable. */ }

        document.querySelectorAll('[data-pwa-connection]').forEach((element) => {
            const label = online ? 'Online' : 'Mode Offline (Tersimpan Lokal)';
            const dot = element.querySelector('[data-pwa-dot]');
            const text = element.querySelector('[data-pwa-text]');
            if (dot) dot.textContent = online ? '🟢' : '🟡';
            if (text) text.textContent = label;
            if (!dot && !text) element.textContent = `${online ? '🟢' : '🟡'} ${label}`;
            element.title = label;
            element.classList.toggle('text-green-700', online);
            element.classList.toggle('text-amber-700', !online);
        });
        document.querySelectorAll('[data-pwa-queue]').forEach((element) => {
            const countElement = element.querySelector('[data-pwa-count]');
            if (countElement) countElement.textContent = count;
            element.hidden = count === 0;
            element.classList.toggle('inline-flex', count > 0);
        });
    }

    function findField(form, field) {
        return [...form.querySelectorAll('input, textarea, select')].find((element) => {
            const bindings = [element.name, ...element.getAttributeNames().filter((name) => name.startsWith('wire:model')).map((name) => element.getAttribute(name))];
            return bindings.some((value) => value === field || value === `data.${field}` || value?.endsWith(`.${field}`));
        });
    }

    function fieldValue(form, field, fallback = '') {
        return findField(form, field)?.value?.trim() || fallback;
    }

    function isUmkmForm(form) {
        return form?.matches('[data-umkm-offline-form]') || (/^\/admin\/umkms\/create\/?$/.test(location.pathname) && Boolean(findField(form, 'nama_umkm')));
    }

    function extractPayload(form) {
        return {
            nama_usaha: fieldValue(form, 'nama_umkm', fieldValue(form, 'nama_usaha')),
            pemilik: fieldValue(form, 'pemilik'),
            dukuh: fieldValue(form, 'dusun', fieldValue(form, 'dukuh')),
            alamat_lengkap: fieldValue(form, 'alamat_lengkap', fieldValue(form, 'rt_rw')),
            bentuk_usaha: fieldValue(form, 'bentuk_usaha', 'Perorangan'),
            jenis_usaha: fieldValue(form, 'kategori', fieldValue(form, 'jenis_usaha')),
            no_hp: fieldValue(form, 'no_hp'),
        };
    }

    function resetOfflineForm(form) {
        form.reset();
        form.querySelectorAll('input, textarea, select').forEach((element) => {
            if (element.type === 'hidden' || ['submit', 'button'].includes(element.type)) return;
            if (['checkbox', 'radio'].includes(element.type)) {
                element.checked = false;
            } else if (element.tagName === 'SELECT') {
                element.selectedIndex = 0;
            } else {
                element.value = '';
            }
            element.dispatchEvent(new Event('input', { bubbles: true }));
            element.dispatchEvent(new Event('change', { bubbles: true }));
        });
    }

    async function registerBackgroundSync() {
        if (!('serviceWorker' in navigator)) return;
        const registration = await navigator.serviceWorker.ready;
        if ('sync' in registration) {
            await registration.sync.register('sync-pending-umkms');
        } else {
            navigator.serviceWorker.controller?.postMessage({ type: 'REGISTER_UMKM_SYNC' });
        }
    }

    async function handleOfflineSubmit(event) {
        if (navigator.onLine || !isUmkmForm(event.target)) return;

        event.preventDefault();
        event.stopImmediatePropagation();
        const form = event.target;
        const payload = extractPayload(form);

        if (!payload.nama_usaha || !payload.pemilik || !payload.dukuh || !payload.alamat_lengkap || !payload.jenis_usaha) {
            showToast('Data wajib UMKM belum lengkap. Lengkapi form sebelum menyimpannya secara offline.', 'red');
            return;
        }

        try {
            await window.saveUmkmOffline(payload);
            resetOfflineForm(form);
            await updateIndicators();
            showToast(OFFLINE_MESSAGE, 'amber');
            await registerBackgroundSync();
        } catch (error) {
            console.error('Gagal menyimpan antrean UMKM offline.', error);
            showToast('Data offline gagal disimpan pada perangkat ini. Silakan coba kembali.', 'red');
        }
    }

    async function triggerSync() {
        const canSync = document.querySelector('meta[name="pwa-umkm-sync-authorized"]')?.content === '1';
        if (!canSync || syncInProgress || !navigator.onLine || typeof window.getPendingUmkms !== 'function') return;
        const pending = await window.getPendingUmkms();
        if (pending.length === 0) { await updateIndicators(); return; }

        syncInProgress = true;
        showToast('🔄 Terhubung ke Internet: Mengirimkan data offline ke server...', 'blue');

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const response = await fetch(SYNC_ENDPOINT, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                },
                body: JSON.stringify({ items: pending }),
            });

            if (!response.ok || response.redirected) throw new Error(`HTTP ${response.status}`);
            const result = await response.json();
            if (!result.success) throw new Error('Server menolak sinkronisasi.');

            await window.removeSyncedUmkms(result.synced_ids || []);
            await updateIndicators();
            showToast(`✅ Berhasil! ${result.synced_count} Data UMKM offline telah tersimpan otomatis ke database server.`, 'green');
        } catch (error) {
            console.error('Sinkronisasi UMKM offline tertunda.', error);
            showToast('Sinkronisasi belum berhasil. Data tetap aman di antrean lokal dan akan dicoba kembali.', 'amber');
            await registerBackgroundSync().catch(() => {});
        } finally {
            syncInProgress = false;
        }
    }

    window.triggerSync = triggerSync;
    window.addEventListener('online', () => { updateIndicators(); triggerSync(); });
    window.addEventListener('offline', updateIndicators);
    document.addEventListener('submit', handleOfflineSubmit, true);

    window.addEventListener('load', async () => {
        if ('serviceWorker' in navigator) {
            try {
                await navigator.serviceWorker.register('/sw.js', { scope: '/' });
                navigator.serviceWorker.addEventListener('message', (event) => {
                    if (event.data?.type === 'SYNC_PENDING_UMKMS') triggerSync();
                    if (event.data?.type === 'UMKM_SYNC_COMPLETE') {
                        updateIndicators();
                        showToast(`✅ Berhasil! ${event.data.synced_count} Data UMKM offline telah tersimpan otomatis ke database server.`, 'green');
                    }
                });
            } catch (error) {
                console.error('Service worker gagal didaftarkan.', error);
            }
        }
        await updateIndicators();
        if (navigator.onLine) triggerSync();
    });
})();