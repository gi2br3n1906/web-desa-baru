@extends('layouts.app')

@section('title', 'Buku UMKM | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Keuangan UMKM" title="Template & Buku Catatan UMKM" description="Unduh template resmi atau catat transaksi langsung di perangkat Anda." />

        <section class="mt-10">
            <h2 class="section-kicker">Template Excel Resmi</h2>
            <div class="mt-6 grid gap-6 md:grid-cols-3">
                @forelse($templates as $template)
                    <article class="content-card flex flex-col p-6">
                        <h3 class="text-xl font-bold text-blue-900">{{ $template->nama_template }}</h3>
                        <p class="mt-3 flex-1 text-slate-600">{{ $template->deskripsi }}</p>
                        <a href="{{ asset('storage/'.$template->file_path) }}" download class="primary-button mt-5">Unduh .xlsx</a>
                    </article>
                @empty
                    <div class="empty-state md:col-span-3">Template belum tersedia.</div>
                @endforelse
            </div>
        </section>

        <section id="buku-umkm" class="content-card mt-14 overflow-hidden">
            <header class="bg-blue-900 p-6 text-white">
                <h2 class="text-2xl font-bold">Buku Catatan Keuangan UMKM</h2>
                @guest
                    <p class="mt-2 text-blue-100">Data Anda saat ini disimpan lokal di browser. Silakan Login dengan akun UMKM Desa untuk menyimpan data secara permanen di server.</p>
                @else
                    <p class="mt-2 text-blue-100">Data tersimpan aman di server Desa Pringanom untuk akun: {{ auth()->user()->name }}.</p>
                @endguest
            </header>

            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    @foreach(['jual'=>'Penjualan', 'kas'=>'Kas', 'hp'=>'Utang/Piutang', 'laba'=>'Laba Rugi'] as $id => $label)
                        <button type="button" data-tab="{{ $id }}" class="rounded-xl px-4 py-2 font-semibold {{ $loop->first ? 'bg-blue-900 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $label }}</button>
                    @endforeach
                </div>

                <form id="book-form" class="mt-6 grid gap-3 md:grid-cols-5">
                    <input id="b-tanggal" type="date" required class="rounded-xl border-slate-300">
                    <input id="b-keterangan" placeholder="Keterangan" required class="rounded-xl border-slate-300">
                    <input id="b-masuk" type="number" min="0" step="0.01" placeholder="Masuk/Penjualan" class="rounded-xl border-slate-300">
                    <input id="b-keluar" type="number" min="0" step="0.01" placeholder="Keluar/Modal" class="rounded-xl border-slate-300">
                    <button class="rounded-xl bg-amber-500 px-4 py-2 font-semibold text-white hover:bg-amber-600">Simpan</button>
                </form>

                <p id="book-feedback" class="mt-4 hidden rounded-xl p-3 text-sm" role="status"></p>

                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-100 text-blue-900">
                            <tr><th class="p-3">Tanggal</th><th class="p-3">Keterangan</th><th class="p-3">Masuk</th><th class="p-3">Keluar</th><th class="p-3">Status</th><th class="p-3">Aksi</th></tr>
                        </thead>
                        <tbody id="book-body"></tbody>
                    </table>
                </div>

                <div id="book-summary" class="mt-6 rounded-xl bg-blue-50 p-5 font-bold text-blue-900"></div>
                <button type="button" onclick="exportCSV()" class="mt-5 rounded-xl border border-blue-900 px-4 py-2 font-semibold text-blue-900">Export CSV</button>
            </div>
        </section>
    </section>

    <script>
        const isAuthenticated = @json(auth()->check());
        const transactionUrls = {
            index: @json(route('transactions.index')),
            store: @json(route('transactions.store')),
            destroy: @json(route('transactions.destroy', ['transaction' => '__TRANSACTION__'])),
            toggle: @json(route('transactions.toggle-lunas', ['transaction' => '__TRANSACTION__'])),
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const KEYS = { jual: 'umkm_jual_v2', kas: 'umkm_kaso_v2', hp: 'umkm_hp_v2' };
        const serverRows = { jual: [], kas: [], hp: [] };
        let active = 'jual';

        const money = value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(Number(value) || 0);
        const escapeHtml = value => String(value ?? '').replace(/[&<>'"]/g, character => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;' }[character]));
        const localGet = key => JSON.parse(localStorage.getItem(KEYS[key]) || '[]');
        const localSet = (key, rows) => localStorage.setItem(KEYS[key], JSON.stringify(rows));
        const apiUrl = (template, id) => template.replace('__TRANSACTION__', id);

        function setFeedback(message, error = false) {
            const feedback = document.getElementById('book-feedback');
            feedback.textContent = message;
            feedback.className = `mt-4 rounded-xl p-3 text-sm ${error ? 'bg-red-50 text-red-800' : 'bg-emerald-50 text-emerald-800'}`;
        }

        function normalizeServerTransaction(transaction) {
            const key = transaction.book_type === 'kaso' ? 'kas' : transaction.book_type;
            return {
                id: transaction.id,
                tanggal: transaction.date?.slice(0, 10),
                keterangan: transaction.title_or_product,
                masuk: ['masuk', 'piutang'].includes(transaction.transaction_type) ? Number(transaction.amount) : 0,
                keluar: ['keluar', 'hutang'].includes(transaction.transaction_type) ? Number(transaction.amount) : 0,
                status: transaction.status,
                key,
            };
        }

        function getRows(key) { return isAuthenticated ? serverRows[key] : localGet(key); }

        function renderRows(key) {
            const rows = getRows(key);
            document.getElementById('book-body').innerHTML = rows.map((row, index) => `<tr class="border-b"><td class="p-3">${escapeHtml(row.tanggal)}</td><td class="p-3">${escapeHtml(row.keterangan)}</td><td class="p-3">${money(row.masuk)}</td><td class="p-3">${money(row.keluar)}</td><td class="p-3">${row.status ? escapeHtml(row.status) : '-'}</td><td class="p-3"><div class="flex flex-wrap gap-3">${isAuthenticated && row.status ? `<button type="button" onclick="toggleLunas('${key}', ${index})" class="text-blue-700">${row.status === 'lunas' ? 'Tandai belum' : 'Tandai lunas'}</button>` : ''}<button type="button" onclick="hapus('${key}', ${index})" class="text-red-600">Hapus</button></div></td></tr>`).join('');
            const incoming = rows.reduce((total, row) => total + Number(row.masuk || 0), 0);
            const outgoing = rows.reduce((total, row) => total + Number(row.keluar || 0), 0);
            document.getElementById('book-summary').textContent = `Total Masuk: ${money(incoming)} • Total Keluar: ${money(outgoing)} • Saldo: ${money(incoming - outgoing)}`;
        }

        function renderJual() { renderRows('jual'); }
        function renderKas() { renderRows('kas'); }
        function renderHP() { renderRows('hp'); }
        function renderLaba() {
            const allRows = isAuthenticated ? [...serverRows.jual, ...serverRows.kas, ...serverRows.hp] : [...localGet('jual'), ...localGet('kas'), ...localGet('hp')];
            const incoming = allRows.reduce((total, row) => total + Number(row.masuk || 0), 0);
            const outgoing = allRows.reduce((total, row) => total + Number(row.keluar || 0), 0);
            document.getElementById('book-body').innerHTML = '';
            document.getElementById('book-summary').textContent = `Estimasi Laba/Rugi: ${money(incoming - outgoing)}`;
        }
        function render() { ({ jual: renderJual, kas: renderKas, hp: renderHP, laba: renderLaba }[active])(); }

        async function serverRequest(url, options = {}) {
            const response = await fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, ...options });
            if (!response.ok) throw new Error('Permintaan ke server gagal.');
            return response.status === 204 ? null : response.json();
        }
        async function loadServerRows() { const response = await serverRequest(transactionUrls.index); response.data.map(normalizeServerTransaction).forEach(row => serverRows[row.key].push(row)); }
        async function tambahServer(key, form) {
            const bookType = key === 'kas' ? 'kaso' : key;
            const requests = [];
            const incoming = Number(form.querySelector('#b-masuk').value || 0);
            const outgoing = Number(form.querySelector('#b-keluar').value || 0);
            const base = { book_type: bookType, date: form.querySelector('#b-tanggal').value, title_or_product: form.querySelector('#b-keterangan').value, status: key === 'hp' ? 'belum' : 'lunas' };
            if (incoming > 0) requests.push(serverRequest(transactionUrls.store, { method: 'POST', body: JSON.stringify({ ...base, transaction_type: key === 'hp' ? 'piutang' : 'masuk', amount: incoming }) }));
            if (outgoing > 0) requests.push(serverRequest(transactionUrls.store, { method: 'POST', body: JSON.stringify({ ...base, transaction_type: key === 'hp' ? 'hutang' : 'keluar', amount: outgoing }) }));
            if (!requests.length) throw new Error('Isi nominal masuk atau keluar terlebih dahulu.');
            const created = await Promise.all(requests);
            created.map(response => normalizeServerTransaction(response.data)).forEach(row => serverRows[row.key].push(row));
        }
        async function hapus(key, index) {
            if (!isAuthenticated) { const rows = localGet(key); rows.splice(index, 1); localSet(key, rows); render(); return; }
            try { await serverRequest(apiUrl(transactionUrls.destroy, serverRows[key][index].id), { method: 'DELETE' }); serverRows[key].splice(index, 1); setFeedback('Transaksi berhasil dihapus.'); render(); } catch (error) { setFeedback(error.message, true); }
        }
        async function toggleLunas(key, index) {
            try { const response = await serverRequest(apiUrl(transactionUrls.toggle, serverRows[key][index].id), { method: 'PATCH' }); serverRows[key][index] = normalizeServerTransaction(response.data); render(); } catch (error) { setFeedback(error.message, true); }
        }
        function exportCSV() { const rows = getRows(active); const csv = ['Tanggal,Keterangan,Masuk,Keluar,Status', ...rows.map(row => [row.tanggal, `"${String(row.keterangan).replaceAll('"', '""')}"`, row.masuk, row.keluar, row.status || ''].join(','))].join('\n'); const link = document.createElement('a'); link.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv' })); link.download = `buku-${active}.csv`; link.click(); URL.revokeObjectURL(link.href); }

        document.getElementById('book-form').onsubmit = async event => {
            event.preventDefault();
            if (active === 'laba') return;
            const form = event.target;
            try {
                if (isAuthenticated) { await tambahServer(active, form); setFeedback('Transaksi tersimpan aman di server.'); } else { const rows = localGet(active); rows.push({ tanggal: form.querySelector('#b-tanggal').value, keterangan: form.querySelector('#b-keterangan').value, masuk: Number(form.querySelector('#b-masuk').value || 0), keluar: Number(form.querySelector('#b-keluar').value || 0) }); localSet(active, rows); }
                form.reset(); render();
            } catch (error) { setFeedback(error.message, true); }
        };
        document.querySelectorAll('[data-tab]').forEach(button => button.onclick = () => { active = button.dataset.tab; document.querySelectorAll('[data-tab]').forEach(tab => tab.className = 'rounded-xl bg-slate-100 px-4 py-2 font-semibold text-slate-700'); button.className = 'rounded-xl bg-blue-900 px-4 py-2 font-semibold text-white'; render(); });
        (async () => { try { if (isAuthenticated) await loadServerRows(); render(); } catch (error) { setFeedback('Data server belum dapat dimuat. Silakan muat ulang halaman.', true); } })();
    </script>
@endsection