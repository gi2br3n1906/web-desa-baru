@extends('layouts.app')

@section('title', 'Buku UMKM | Desa Pringanom')

@section('content')
    <section class="min-h-screen bg-slate-50 py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-page-header
                eyebrow="Keuangan UMKM"
                title="Buku UMKM Desa"
                description="Penjualan dan kas operasional dicatat terpisah, biar jelas mana omzet dan mana biaya."
            />

            <section class="mt-8 rounded-2xl bg-blue-900 p-5 text-white shadow-xl sm:p-7">
                <div class="flex items-start gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-xl font-black text-blue-950 shadow-sm" aria-hidden="true">UM</div>
                    <div>
                        <h2 class="text-xl font-bold sm:text-2xl">Buku UMKM Desa</h2>
                        <p class="mt-1 max-w-3xl text-sm leading-6 text-blue-100">Kelola penjualan, kas operasional, utang-piutang, dan laba rugi dalam satu buku yang mudah dipahami.</p>
                    </div>
                </div>
                @guest
                    <p class="mt-5 rounded-xl bg-blue-950/45 p-3 text-sm leading-6 text-blue-100">Data Anda saat ini disimpan lokal di browser. Silakan Login dengan akun UMKM Desa agar data tersimpan dan tersinkron ke server.</p>
                @else
                    <p class="mt-5 rounded-xl bg-blue-950/45 p-3 text-sm leading-6 text-blue-100">Data tersimpan aman di server Desa Pringanom untuk akun: {{ auth()->user()->name }}.</p>
                @endguest
            </section>

            <section class="mt-6 overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                <div class="overflow-x-auto border-b border-slate-200 bg-slate-100/80 px-3 pt-3 sm:px-5">
                    <div class="flex min-w-max gap-2" role="tablist" aria-label="Buku keuangan UMKM">
                        <button type="button" data-main-tab="jual" data-color="blue" class="main-tab rounded-t-xl bg-blue-900 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800" onclick="showTab('jual', this)" role="tab" aria-selected="true">🔵 Penjualan</button>
                        <button type="button" data-main-tab="kaso" data-color="green" class="main-tab rounded-t-xl bg-emerald-900/70 px-4 py-3 text-sm font-bold text-white/75 transition hover:bg-emerald-900" onclick="showTab('kaso', this)" role="tab" aria-selected="false">🟢 Kas Operasional</button>
                        <button type="button" data-main-tab="hp" data-color="green" class="main-tab rounded-t-xl bg-emerald-900/70 px-4 py-3 text-sm font-bold text-white/75 transition hover:bg-emerald-900" onclick="showTab('hp', this)" role="tab" aria-selected="false">🟢 Utang &amp; Piutang</button>
                        <button type="button" data-main-tab="laba" data-color="dark" class="main-tab rounded-t-xl bg-slate-800/80 px-4 py-3 text-sm font-bold text-white/75 transition hover:bg-slate-800" onclick="showTab('laba', this)" role="tab" aria-selected="false">⚫ Laba Rugi</button>
                        <button type="button" data-main-tab="panduan" data-color="neutral" class="main-tab rounded-t-xl bg-slate-600/80 px-4 py-3 text-sm font-bold text-white/75 transition hover:bg-slate-600" onclick="showTab('panduan', this)" role="tab" aria-selected="false">📖 Panduan</button>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 sm:p-8">
                    <p id="book-feedback" class="mb-4 hidden rounded-xl p-3 text-sm" role="status"></p>

                    <section id="tab-jual" data-main-panel="jual" role="tabpanel">
                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-blue-900">Khusus pendapatan jualan</span>
                        <h2 class="mt-3 text-2xl font-bold text-blue-950">Buku &amp; Rekap Penjualan</h2>
                        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">Catat tiap transaksi jualan di sini. Biaya bahan baku, transport, dan biaya lainnya dicatat di tab Kas Operasional.</p>

                        <div class="mt-6 flex flex-wrap gap-2" role="tablist" aria-label="Rekap penjualan">
                            <button type="button" data-sub-tab="jual-harian" class="sub-tab rounded-full border border-blue-900 bg-blue-900 px-4 py-2 text-sm font-semibold text-white" onclick="showSub('jual-harian', this)" role="tab" aria-selected="true">Catatan Harian</button>
                            <button type="button" data-sub-tab="jual-minggu" class="sub-tab rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-600" onclick="showSub('jual-minggu', this)" role="tab" aria-selected="false">Rekap Mingguan</button>
                            <button type="button" data-sub-tab="jual-bulan" class="sub-tab rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-600" onclick="showSub('jual-bulan', this)" role="tab" aria-selected="false">Rekap Bulanan</button>
                        </div>

                        <div id="jual-harian" data-sub-panel="jual-harian" class="mt-6">
                            <div id="jual-summary" class="grid gap-4 sm:grid-cols-2"></div>
                            <div class="mt-5 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <form id="jual-form" class="grid gap-4 md:grid-cols-4" onsubmit="return false;">
                                    <div>
                                        <label for="j-tanggal" class="field-label">Tanggal</label>
                                        <input type="date" id="j-tanggal" required class="field-input">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="j-produk" class="field-label">Nama Produk</label>
                                        <input type="text" id="j-produk" placeholder="Contoh: Keripik Singkong 200gr" required class="field-input">
                                    </div>
                                    <div>
                                        <label for="j-qty" class="field-label">Qty</label>
                                        <input type="number" id="j-qty" min="1" step="1" placeholder="0" required class="field-input">
                                    </div>
                                    <div>
                                        <label for="j-harga" class="field-label">Harga Satuan (Rp)</label>
                                        <input type="number" id="j-harga" min="0" step="500" placeholder="0" required class="field-input">
                                    </div>
                                    <div class="flex flex-wrap items-end gap-2 md:col-span-3">
                                        <button type="button" class="primary-button" onclick="tambahJual()">+ Simpan Penjualan</button>
                                        <button type="button" class="secondary-button" onclick="exportCSV('jual')">⬇ Unduh CSV</button>
                                        <button type="button" class="danger-button" onclick="hapusSemua('jual')">Hapus Semua Data Contoh</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-5 overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                                <table class="book-table">
                                    <thead><tr><th>Tanggal</th><th>Produk</th><th class="text-right">Qty</th><th class="text-right">Harga Satuan</th><th class="text-right">Total</th><th>Aksi</th></tr></thead>
                                    <tbody id="jual-body"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="jual-minggu" data-sub-panel="jual-minggu" class="mt-6 hidden">
                            <p class="mb-4 text-sm leading-6 text-slate-600">Minggu mengikuti kalender ISO (Senin adalah awal minggu). Hanya minggu yang memiliki transaksi yang ditampilkan.</p>
                            <div class="overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                                <table class="book-table"><thead><tr><th>Minggu</th><th>Periode</th><th class="text-right">Qty Terjual</th><th class="text-right">Total Pendapatan</th></tr></thead><tbody id="jual-minggu-body"></tbody></table>
                            </div>
                        </div>

                        <div id="jual-bulan" data-sub-panel="jual-bulan" class="mt-6 hidden">
                            <div class="overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                                <table class="book-table"><thead><tr><th>Bulan</th><th class="text-right">Qty Terjual</th><th class="text-right">Total Pendapatan</th></tr></thead><tbody id="jual-bulan-body"></tbody></table>
                            </div>
                        </div>
                    </section>

                    <section id="tab-kaso" data-main-panel="kaso" class="hidden" role="tabpanel">
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-900">Modal, pendapatan lain &amp; semua pengeluaran</span>
                        <h2 class="mt-3 text-2xl font-bold text-blue-950">Buku Kas Operasional</h2>
                        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">Uang masuk non-jualan dan semua pengeluaran usaha. Penjualan tidak dicatat di sini.</p>
                        <div id="kaso-summary" class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3"></div>
                        <div class="mt-5 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                            <form id="kaso-form" class="grid gap-4 md:grid-cols-2" onsubmit="return false;">
                                <div><label for="k-tanggal" class="field-label">Tanggal</label><input type="date" id="k-tanggal" required class="field-input"></div>
                                <div><label for="k-jenis" class="field-label">Jenis</label><select id="k-jenis" class="field-input"><option value="masuk">Kas Masuk</option><option value="keluar">Kas Keluar</option></select></div>
                                <div class="md:col-span-2"><label for="k-ket" class="field-label">Keterangan</label><input type="text" id="k-ket" placeholder="Contoh: Beli bahan baku singkong" required class="field-input"></div>
                                <div><label for="k-kategori" class="field-label">Kategori</label><select id="k-kategori" class="field-input"><option>Modal</option><option>Pendapatan Lain</option><option>Pembelian Bahan Baku</option><option>Transport</option><option>Operasional</option><option>Gaji/Upah</option><option>Prive/Pribadi</option><option>Lain-lain</option></select></div>
                                <div><label for="k-jumlah" class="field-label">Jumlah (Rp)</label><input type="number" id="k-jumlah" min="0" step="1000" placeholder="0" required class="field-input"></div>
                                <div class="flex flex-wrap gap-2 md:col-span-2"><button type="button" class="primary-button" onclick="tambahKas()">+ Simpan Transaksi</button><button type="button" class="secondary-button" onclick="exportCSV('kaso')">⬇ Unduh CSV</button><button type="button" class="danger-button" onclick="hapusSemua('kaso')">Hapus Semua Data Contoh</button></div>
                            </form>
                        </div>
                        <div class="mt-5 overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-200"><table class="book-table"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Kategori</th><th>Jenis</th><th class="text-right">Jumlah</th><th class="text-right">Saldo</th><th>Aksi</th></tr></thead><tbody id="kaso-body"></tbody></table></div>
                    </section>

                    <section id="tab-hp" data-main-panel="hp" class="hidden" role="tabpanel">
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-900">Di luar kas harian</span>
                        <h2 class="mt-3 text-2xl font-bold text-blue-950">Catatan Utang &amp; Piutang</h2>
                        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">Piutang adalah uang yang akan Anda terima. Hutang adalah uang yang harus Anda bayar. Klik badge status untuk menandai lunas.</p>
                        <div id="hp-summary" class="mt-6 grid gap-4 sm:grid-cols-2"></div>
                        <div class="mt-5 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                            <form id="hp-form" class="grid gap-4 md:grid-cols-2" onsubmit="return false;">
                                <div><label for="h-tanggal" class="field-label">Tanggal</label><input type="date" id="h-tanggal" required class="field-input"></div>
                                <div><label for="h-jenis" class="field-label">Jenis</label><select id="h-jenis" class="field-input"><option value="piutang">Piutang (akan diterima)</option><option value="hutang">Hutang (akan dibayar)</option></select></div>
                                <div><label for="h-nama" class="field-label">Nama Pihak</label><input type="text" id="h-nama" placeholder="Nama orang/toko" required class="field-input"></div>
                                <div><label for="h-jumlah" class="field-label">Jumlah (Rp)</label><input type="number" id="h-jumlah" min="0" step="1000" required class="field-input"></div>
                                <div class="md:col-span-2"><label for="h-ket" class="field-label">Keterangan</label><input type="text" id="h-ket" placeholder="Contoh: Ambil barang, bayar menyusul" class="field-input"></div>
                                <div class="flex flex-wrap gap-2 md:col-span-2"><button type="button" class="primary-button" onclick="tambahHP()">+ Simpan Catatan</button><button type="button" class="secondary-button" onclick="exportCSV('hp')">⬇ Unduh CSV</button><button type="button" class="danger-button" onclick="hapusSemua('hp')">Hapus Semua Data Contoh</button></div>
                            </form>
                        </div>
                        <div class="mt-5 overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-200"><table class="book-table"><thead><tr><th>Tanggal</th><th>Nama</th><th>Jenis</th><th>Keterangan</th><th class="text-right">Jumlah</th><th>Status</th><th>Aksi</th></tr></thead><tbody id="hp-body"></tbody></table></div>
                    </section>

                    <section id="tab-laba" data-main-panel="laba" class="hidden" role="tabpanel">
                        <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-bold uppercase tracking-wide text-slate-700">Ringkasan otomatis</span>
                        <h2 class="mt-3 text-2xl font-bold text-blue-950">Rekap Laba Rugi Bulanan</h2>
                        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">Digabung otomatis dari Buku Penjualan dan Buku Kas Operasional — tidak perlu isi manual.</p>
                        <div class="mt-6 overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-200"><table class="book-table"><thead><tr><th>Bulan</th><th class="text-right">Penjualan</th><th class="text-right">Pendapatan Lain</th><th class="text-right">Pengeluaran Usaha</th><th class="text-right">Prive/Pribadi</th><th class="text-right">Laba/(Rugi)</th></tr></thead><tbody id="laba-body"></tbody></table></div>
                        <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-slate-700">Laba/(Rugi) = Penjualan + Pendapatan Lain − Pengeluaran Usaha. Prive/Pribadi ditampilkan terpisah dan <strong>tidak</strong> dihitung sebagai biaya usaha karena merupakan penarikan pribadi.</div>
                    </section>

                    <section id="tab-panduan" data-main-panel="panduan" class="hidden" role="tabpanel">
                        <h2 class="text-2xl font-bold text-blue-950">Panduan Singkat</h2>
                        <div class="mt-6 grid gap-5 lg:grid-cols-2">
                            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><h3 class="text-lg font-bold text-blue-900">🔵 Buku &amp; Rekap Penjualan</h3><p class="mt-2 text-sm leading-6 text-slate-600">Isi tiap kali ada transaksi jualan. Total dihitung otomatis (Qty × Harga Satuan). Rekap Mingguan dan Bulanan otomatis mengelompokkan data ini.</p></article>
                            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><h3 class="text-lg font-bold text-emerald-900">🟢 Buku Kas Operasional</h3><p class="mt-2 text-sm leading-6 text-slate-600">Isi uang masuk yang bukan dari jualan (modal atau pendapatan lain) dan semua pengeluaran: bahan baku, transport, operasional, gaji, sampai uang pribadi.</p></article>
                            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><h3 class="text-lg font-bold text-emerald-900">🟢 Utang &amp; Piutang</h3><p class="mt-2 text-sm leading-6 text-slate-600">Piutang berarti orang lain berutang kepada usaha Anda. Hutang berarti usaha Anda berutang kepada orang lain. Klik badge status untuk menandai lunas.</p></article>
                            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><h3 class="text-lg font-bold text-slate-800">⚫ Laba Rugi</h3><p class="mt-2 text-sm leading-6 text-slate-600">Otomatis dari dua buku di atas. Laba positif berarti pendapatan lebih besar daripada pengeluaran; nilai negatif berarti rugi.</p></article>
                        </div>
                        <article class="mt-5 rounded-xl bg-amber-50 p-5 ring-1 ring-amber-200"><h3 class="text-lg font-bold text-slate-800">Soal Data Contoh</h3><p class="mt-2 text-sm leading-6 text-slate-600">Pada mode tamu, beberapa baris contoh bertanda biru muda disiapkan agar Anda tahu cara mengisi. Data contoh boleh dihapus satu per satu atau dengan tombol “Hapus Data Contoh”.</p></article>
                        <article class="mt-5 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><h3 class="text-lg font-bold text-slate-800">Tips Praktis</h3><ul class="mt-2 list-disc space-y-2 pl-5 text-sm leading-6 text-slate-600"><li>Catat transaksi hari itu juga, jangan menunggu menumpuk.</li><li>Mode tamu menyimpan data di browser; unduh CSV secara rutin sebagai cadangan.</li><li>Simpan nota atau struk fisik sebagai bukti walau sudah dicatat di sini.</li></ul></article>
                    </section>
                </div>
            </section>

            <section class="mt-10">
                <h2 class="section-kicker">Template Excel Resmi</h2>
                <div class="mt-5 grid gap-5 md:grid-cols-3">
                    @forelse($templates as $template)
                        <article class="content-card flex flex-col p-6">
                            <h3 class="text-xl font-bold text-blue-900">{{ $template->nama_template }}</h3>
                            <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">{{ $template->deskripsi }}</p>
                            <a href="{{ asset('storage/'.$template->file_path) }}" download class="primary-button mt-5">Unduh .xlsx</a>
                        </article>
                    @empty
                        <div class="empty-state md:col-span-3">Template belum tersedia.</div>
                    @endforelse
                </div>
            </section>

            <p class="mt-5 text-center text-xs leading-5 text-slate-500">@guest Data tamu disimpan langsung di perangkat/browser yang Anda pakai dan tidak dikirim ke server mana pun. @else Data akun disimpan pada server Desa Pringanom dan dibatasi untuk akun Anda. @endguest<br>Gunakan tombol “Unduh CSV” secara berkala untuk mencadangkan data.</p>
        </div>
    </section>

    <style>
        .field-label { display: block; margin-bottom: .375rem; font-size: .75rem; font-weight: 700; letter-spacing: .025em; text-transform: uppercase; color: #475569; }
        .field-input { width: 100%; border-radius: .75rem; border-color: #cbd5e1; background: #fff; padding: .625rem .75rem; color: #1e293b; box-shadow: 0 1px 2px rgb(15 23 42 / .04); }
        .field-input:focus { border-color: #1e3a8a; outline: 2px solid rgb(30 58 138 / .2); outline-offset: 1px; }
        .primary-button, .secondary-button, .danger-button { display: inline-flex; align-items: center; justify-content: center; border-radius: .75rem; padding: .625rem 1rem; font-size: .875rem; font-weight: 700; transition: filter .15s ease, background-color .15s ease; }
        .primary-button { background: #f59e0b; color: #172554; }
        .primary-button:hover { background: #d97706; color: #fff; }
        .secondary-button { border: 1px solid #1e3a8a; background: #fff; color: #1e3a8a; }
        .secondary-button:hover { background: #eff6ff; }
        .danger-button { border: 1px solid #b91c1c; background: #fff; color: #b91c1c; }
        .danger-button:hover { background: #fef2f2; }
        .book-table { width: 100%; min-width: 680px; border-collapse: collapse; text-align: left; font-size: .875rem; color: #334155; }
        .book-table th { border-bottom: 2px solid #cbd5e1; padding: .75rem; font-size: .6875rem; font-weight: 800; letter-spacing: .03em; text-transform: uppercase; color: #475569; }
        .book-table td { border-bottom: 1px solid #e2e8f0; padding: .75rem; vertical-align: top; }
        .book-table tbody tr:hover td { background: #fffbeb; }
        .book-table tbody tr.example-row td { background: #eff6ff; }
        .book-table .number { white-space: nowrap; font-variant-numeric: tabular-nums; text-align: right; }
        .stat-card { border-radius: .75rem; background: #fff; padding: 1rem 1.125rem; box-shadow: 0 1px 4px rgb(15 23 42 / .08); }
        .stat-label { font-size: .6875rem; font-weight: 800; letter-spacing: .03em; text-transform: uppercase; color: #64748b; }
        .stat-value { margin-top: .25rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 1.125rem; font-weight: 700; color: #1e293b; }
        .empty-row { padding: 1.75rem .625rem !important; text-align: center; color: #64748b; }
        .status-badge { cursor: pointer; border-radius: 9999px; padding: .25rem .625rem; font-size: .6875rem; font-weight: 800; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-unpaid { background: #fef3c7; color: #92400e; }
        .type-in { border-radius: 9999px; background: #dcfce7; padding: .25rem .625rem; font-size: .6875rem; font-weight: 800; color: #166534; }
        .type-out { border-radius: 9999px; background: #fee2e2; padding: .25rem .625rem; font-size: .6875rem; font-weight: 800; color: #991b1b; }
        .example-badge { margin-left: .375rem; border-radius: 9999px; background: #dbeafe; padding: .125rem .5rem; font-size: .625rem; font-weight: 800; color: #1d4ed8; }
        .row-action { border: 0; background: transparent; padding: .25rem .375rem; font-size: .75rem; font-weight: 700; color: #b91c1c; }
        .row-action:hover { text-decoration: underline; }
        .positive { color: #166534; font-weight: 700; }
        .negative { color: #b91c1c; font-weight: 700; }
    </style>

    <script>
        const isAuthenticated = @json(auth()->check());
        const transactionUrls = {
            index: @json(route('transactions.index')),
            store: @json(route('transactions.store')),
            destroy: @json(route('transactions.destroy', ['transaction' => '__TRANSACTION__'])),
            toggle: @json(route('transactions.toggle-lunas', ['transaction' => '__TRANSACTION__'])),
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const STORAGE_KEYS = { jual: 'umkm_jual_v2', kaso: 'umkm_kaso_v2', hp: 'umkm_hp_v2' };
        const serverRows = { jual: [], kaso: [], hp: [] };
        let jual = [];
        let kaso = [];
        let hp = [];

        const seedJual = [
            { id: 1, tanggal: '2026-01-05', produk: 'Keripik Singkong 200gr', qty: 10, harga: 15000, contoh: true },
            { id: 2, tanggal: '2026-01-12', produk: 'Keripik Singkong 200gr', qty: 8, harga: 15000, contoh: true },
            { id: 3, tanggal: '2026-02-03', produk: 'Keripik Pisang 200gr', qty: 12, harga: 17000, contoh: true },
        ];
        const seedKaso = [
            { id: 1, tanggal: '2026-01-01', ket: 'Saldo Awal Kas/Bank', kategori: 'Modal', jenis: 'masuk', jumlah: 2000000, contoh: true },
            { id: 2, tanggal: '2026-01-03', ket: 'Beli bahan baku singkong & minyak', kategori: 'Pembelian Bahan Baku', jenis: 'keluar', jumlah: 250000, contoh: true },
            { id: 3, tanggal: '2026-01-06', ket: 'Ongkos ojek antar barang ke warung', kategori: 'Transport', jenis: 'keluar', jumlah: 30000, contoh: true },
        ];
        const seedHP = [
            { id: 1, tanggal: '2026-01-05', nama: 'Toko Sumber Jaya', jenis: 'hutang', jumlah: 300000, ket: 'Beli bahan baku, bayar 2 minggu lagi', status: 'belum', contoh: true },
            { id: 2, tanggal: '2026-01-06', nama: 'Bu Rina (pelanggan)', jenis: 'piutang', jumlah: 150000, ket: 'Ambil barang, bayar menyusul', status: 'belum', contoh: true },
        ];

        const fmt = value => `Rp${Math.round(Number(value) || 0).toLocaleString('id-ID')}`;
        const todayISO = () => new Date().toISOString().slice(0, 10);
        const monthNamesShort = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const monthNamesLong = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const escapeHtml = value => String(value ?? '').replace(/[&<>'"]/g, character => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;' }[character]));
        const localGet = (key, seed) => {
            try {
                const raw = localStorage.getItem(STORAGE_KEYS[key]);
                if (raw === null) {
                    localStorage.setItem(STORAGE_KEYS[key], JSON.stringify(seed));
                    return [...seed];
                }
                const data = JSON.parse(raw);
                return Array.isArray(data) ? data : [...seed];
            } catch (error) {
                return [...seed];
            }
        };
        const localSet = (key, data) => localStorage.setItem(STORAGE_KEYS[key], JSON.stringify(data));
        const apiUrl = (template, id) => template.replace('__TRANSACTION__', id);

        function setFeedback(message, error = false) {
            const feedback = document.getElementById('book-feedback');
            feedback.textContent = message;
            feedback.className = `mb-4 rounded-xl p-3 text-sm ${error ? 'bg-red-50 text-red-800' : 'bg-emerald-50 text-emerald-800'}`;
        }

        function serverRequest(url, options = {}) {
            return fetch(url, {
                credentials: 'same-origin',
                headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                ...options,
            }).then(async response => {
                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    const validation = payload.errors ? Object.values(payload.errors).flat().join(' ') : '';
                    throw new Error(validation || payload.message || 'Permintaan ke server gagal.');
                }
                return response.status === 204 ? null : response.json();
            });
        }

        function normalizeServerTransaction(transaction) {
            const bookType = transaction.book_type === 'kaso' ? 'kaso' : transaction.book_type;
            if (bookType === 'jual') {
                return { id: transaction.id, tanggal: String(transaction.date).slice(0, 10), produk: transaction.title_or_product, qty: Number(transaction.qty || 0), harga: Number(transaction.price_per_unit || 0), contoh: false };
            }
            if (bookType === 'hp') {
                return { id: transaction.id, tanggal: String(transaction.date).slice(0, 10), nama: transaction.title_or_product, jenis: transaction.transaction_type, jumlah: Number(transaction.amount || 0), ket: transaction.notes || '', status: transaction.status || 'belum', contoh: false };
            }
            return { id: transaction.id, tanggal: String(transaction.date).slice(0, 10), ket: transaction.title_or_product, kategori: transaction.category || 'Lain-lain', jenis: transaction.transaction_type || 'keluar', jumlah: Number(transaction.amount || 0), contoh: false };
        }

        async function loadServerRows() {
            const response = await serverRequest(transactionUrls.index);
            response.data.map(normalizeServerTransaction).forEach(row => {
                if (row.produk !== undefined) serverRows.jual.push(row);
                else if (row.nama !== undefined) serverRows.hp.push(row);
                else serverRows.kaso.push(row);
            });
            jual = serverRows.jual;
            kaso = serverRows.kaso;
            hp = serverRows.hp;
        }

        function showTab(name, button = window.event?.currentTarget) {
            document.querySelectorAll('[data-main-panel]').forEach(panel => panel.classList.toggle('hidden', panel.dataset.mainPanel !== name));
            document.querySelectorAll('.main-tab').forEach(tab => {
                const active = tab.dataset.mainTab === name;
                tab.classList.toggle('opacity-100', active);
                tab.classList.toggle('opacity-60', !active);
                tab.classList.toggle('text-white', active);
                tab.classList.toggle('text-white/75', !active);
                tab.setAttribute('aria-selected', String(active));
            });
            if (button) button.setAttribute('aria-selected', 'true');
            if (name === 'laba') renderLaba();
        }

        function showSub(id, button = window.event?.currentTarget) {
            document.querySelectorAll('[data-sub-panel]').forEach(panel => panel.classList.toggle('hidden', panel.dataset.subPanel !== id));
            document.querySelectorAll('.sub-tab').forEach(tab => {
                const active = tab.dataset.subTab === id;
                tab.classList.toggle('bg-blue-900', active);
                tab.classList.toggle('text-white', active);
                tab.classList.toggle('border-blue-900', active);
                tab.classList.toggle('bg-white', !active);
                tab.classList.toggle('text-slate-600', !active);
                tab.classList.toggle('border-slate-300', !active);
                tab.setAttribute('aria-selected', String(active));
            });
            if (id === 'jual-minggu') renderMinggu();
            if (id === 'jual-bulan') renderBulan();
            if (button) button.setAttribute('aria-selected', 'true');
        }

        function fmtTgl(iso) {
            const [year, month, day] = String(iso).slice(0, 10).split('-');
            return year && month && day ? `${day}/${month}/${year}` : '-';
        }

        function fmtDateShort(date) {
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        function emptyRow(columns, message) {
            return `<tr><td colspan="${columns}" class="empty-row">${message}</td></tr>`;
        }

        function exampleBadge(row) {
            return row.contoh ? '<span class="example-badge">Contoh</span>' : '';
        }

        function renderJual() {
            const sorted = [...jual].sort((a, b) => a.tanggal.localeCompare(b.tanggal) || Number(a.id) - Number(b.id));
            let totalQty = 0;
            let totalRevenue = 0;
            const body = document.getElementById('jual-body');
            body.innerHTML = sorted.length ? sorted.map(transaction => {
                const total = Number(transaction.qty) * Number(transaction.harga);
                totalQty += Number(transaction.qty);
                totalRevenue += total;
                return `<tr class="${transaction.contoh ? 'example-row' : ''}"><td>${fmtTgl(transaction.tanggal)}${exampleBadge(transaction)}</td><td>${escapeHtml(transaction.produk)}</td><td class="number">${transaction.qty}</td><td class="number">${fmt(transaction.harga)}</td><td class="number">${fmt(total)}</td><td><button type="button" class="row-action" onclick="hapusJual(${transaction.id})">Hapus</button></td></tr>`;
            }).join('') : emptyRow(6, 'Belum ada penjualan. Tambahkan transaksi pertama di form di atas.');
            document.getElementById('jual-summary').innerHTML = `<div class="stat-card"><div class="stat-label">Total Qty Terjual</div><div class="stat-value">${totalQty}</div></div><div class="stat-card"><div class="stat-label">Total Pendapatan</div><div class="stat-value positive">${fmt(totalRevenue)}</div></div>`;
        }

        function isoWeekInfo(dateString) {
            const date = new Date(`${dateString}T00:00:00`);
            const target = new Date(date.valueOf());
            const dayNumber = (date.getDay() + 6) % 7;
            target.setDate(target.getDate() - dayNumber + 3);
            const firstThursday = new Date(target.getFullYear(), 0, 4);
            const week = 1 + Math.round((target - firstThursday) / 86400000 / 7);
            const monday = new Date(date);
            monday.setDate(date.getDate() - dayNumber);
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            return { year: target.getFullYear(), week, monday, sunday };
        }

        function renderMinggu() {
            const byWeek = {};
            jual.forEach(transaction => {
                const info = isoWeekInfo(transaction.tanggal);
                const key = `${info.year}-W${String(info.week).padStart(2, '0')}`;
                byWeek[key] ??= { qty: 0, total: 0, monday: info.monday, sunday: info.sunday, week: info.week, year: info.year };
                byWeek[key].qty += Number(transaction.qty);
                byWeek[key].total += Number(transaction.qty) * Number(transaction.harga);
            });
            const rows = Object.keys(byWeek).sort().map(key => {
                const week = byWeek[key];
                return `<tr><td>Minggu ${week.week} / ${week.year}</td><td>${fmtDateShort(week.monday)} – ${fmtDateShort(week.sunday)}</td><td class="number">${week.qty}</td><td class="number">${fmt(week.total)}</td></tr>`;
            }).join('');
            document.getElementById('jual-minggu-body').innerHTML = rows || emptyRow(4, 'Belum ada data penjualan.');
        }

        function renderBulan() {
            const byMonth = {};
            jual.forEach(transaction => {
                const key = String(transaction.tanggal).slice(0, 7);
                byMonth[key] ??= { qty: 0, total: 0 };
                byMonth[key].qty += Number(transaction.qty);
                byMonth[key].total += Number(transaction.qty) * Number(transaction.harga);
            });
            const rows = Object.keys(byMonth).sort().map(key => {
                const [year, month] = key.split('-');
                return `<tr><td>${monthNamesShort[Number(month) - 1]} ${year}</td><td class="number">${byMonth[key].qty}</td><td class="number">${fmt(byMonth[key].total)}</td></tr>`;
            }).join('');
            document.getElementById('jual-bulan-body').innerHTML = rows || emptyRow(3, 'Belum ada data penjualan.');
        }

        function renderKas() {
            const sorted = [...kaso].sort((a, b) => a.tanggal.localeCompare(b.tanggal) || Number(a.id) - Number(b.id));
            let saldo = 0;
            let totalIn = 0;
            let totalOut = 0;
            const body = document.getElementById('kaso-body');
            body.innerHTML = sorted.length ? sorted.map(transaction => {
                const amount = Number(transaction.jumlah);
                if (transaction.jenis === 'masuk') { saldo += amount; totalIn += amount; } else { saldo -= amount; totalOut += amount; }
                return `<tr class="${transaction.contoh ? 'example-row' : ''}"><td>${fmtTgl(transaction.tanggal)}${exampleBadge(transaction)}</td><td>${escapeHtml(transaction.ket)}</td><td>${escapeHtml(transaction.kategori)}</td><td><span class="${transaction.jenis === 'masuk' ? 'type-in' : 'type-out'}">${transaction.jenis === 'masuk' ? 'Masuk' : 'Keluar'}</span></td><td class="number">${fmt(amount)}</td><td class="number">${fmt(saldo)}</td><td><button type="button" class="row-action" onclick="hapusKas(${transaction.id})">Hapus</button></td></tr>`;
            }).join('') : emptyRow(7, 'Belum ada transaksi kas operasional.');
            document.getElementById('kaso-summary').innerHTML = `<div class="stat-card"><div class="stat-label">Saldo Kas Operasional</div><div class="stat-value">${fmt(saldo)}</div></div><div class="stat-card"><div class="stat-label">Total Masuk</div><div class="stat-value positive">${fmt(totalIn)}</div></div><div class="stat-card"><div class="stat-label">Total Keluar</div><div class="stat-value negative">${fmt(totalOut)}</div></div>`;
        }

        function renderHP() {
            let totalReceivable = 0;
            let totalPayable = 0;
            const body = document.getElementById('hp-body');
            const sorted = [...hp].sort((a, b) => a.tanggal.localeCompare(b.tanggal) || Number(a.id) - Number(b.id));
            body.innerHTML = sorted.length ? sorted.map(transaction => {
                if (transaction.status === 'belum') transaction.jenis === 'piutang' ? totalReceivable += Number(transaction.jumlah) : totalPayable += Number(transaction.jumlah);
                const statusLabel = transaction.status === 'lunas' ? 'Lunas' : 'Belum Lunas';
                return `<tr class="${transaction.contoh ? 'example-row' : ''}"><td>${fmtTgl(transaction.tanggal)}${exampleBadge(transaction)}</td><td>${escapeHtml(transaction.nama)}</td><td><span class="${transaction.jenis === 'piutang' ? 'type-in' : 'type-out'}">${transaction.jenis === 'piutang' ? 'Piutang' : 'Hutang'}</span></td><td>${escapeHtml(transaction.ket || '-')}</td><td class="number">${fmt(transaction.jumlah)}</td><td><button type="button" class="status-badge ${transaction.status === 'lunas' ? 'status-paid' : 'status-unpaid'}" onclick="toggleLunas(${transaction.id})">${statusLabel}</button></td><td><button type="button" class="row-action" onclick="hapusHP(${transaction.id})">Hapus</button></td></tr>`;
            }).join('') : emptyRow(7, 'Belum ada catatan utang/piutang.');
            document.getElementById('hp-summary').innerHTML = `<div class="stat-card"><div class="stat-label">Piutang Belum Lunas</div><div class="stat-value positive">${fmt(totalReceivable)}</div></div><div class="stat-card"><div class="stat-label">Hutang Belum Lunas</div><div class="stat-value negative">${fmt(totalPayable)}</div></div>`;
        }

        function renderLaba() {
            const byMonth = {};
            jual.forEach(transaction => {
                const key = String(transaction.tanggal).slice(0, 7);
                byMonth[key] ??= { penjualan: 0, pendapatanLain: 0, pengeluaran: 0, prive: 0 };
                byMonth[key].penjualan += Number(transaction.qty) * Number(transaction.harga);
            });
            kaso.forEach(transaction => {
                const key = String(transaction.tanggal).slice(0, 7);
                byMonth[key] ??= { penjualan: 0, pendapatanLain: 0, pengeluaran: 0, prive: 0 };
                if (transaction.jenis === 'masuk' && transaction.kategori === 'Pendapatan Lain') byMonth[key].pendapatanLain += Number(transaction.jumlah);
                if (transaction.jenis === 'keluar' && transaction.kategori === 'Prive/Pribadi') byMonth[key].prive += Number(transaction.jumlah);
                else if (transaction.jenis === 'keluar') byMonth[key].pengeluaran += Number(transaction.jumlah);
            });
            const rows = Object.keys(byMonth).sort().map(key => {
                const [year, month] = key.split('-');
                const data = byMonth[key];
                const laba = data.penjualan + data.pendapatanLain - data.pengeluaran;
                return `<tr><td>${monthNamesLong[Number(month) - 1]} ${year}</td><td class="number">${fmt(data.penjualan)}</td><td class="number">${fmt(data.pendapatanLain)}</td><td class="number">${fmt(data.pengeluaran)}</td><td class="number">${fmt(data.prive)}</td><td class="number ${laba >= 0 ? 'positive' : 'negative'}">${fmt(laba)}</td></tr>`;
            }).join('');
            document.getElementById('laba-body').innerHTML = rows || emptyRow(6, 'Belum ada data. Isi Buku Penjualan dan Kas Operasional terlebih dahulu.');
        }

        function confirmDelete(message) { return window.confirm(message); }

        async function createTransaction(payload) {
            const response = await serverRequest(transactionUrls.store, { method: 'POST', body: JSON.stringify(payload) });
            return normalizeServerTransaction(response.data);
        }

        async function deleteServerRow(row) {
            await serverRequest(apiUrl(transactionUrls.destroy, row.id), { method: 'DELETE' });
        }

        async function hapusSemua(which) {
            if (!confirmDelete('Hapus SEMUA data di buku ini? Data akan hilang dan tidak bisa dikembalikan.')) return;
            if (!isAuthenticated) {
                if (which === 'jual') { jual = []; localSet('jual', jual); renderJual(); }
                if (which === 'kaso') { kaso = []; localSet('kaso', kaso); renderKas(); }
                if (which === 'hp') { hp = []; localSet('hp', hp); renderHP(); }
                return;
            }
            try {
                const rows = which === 'jual' ? jual : which === 'kaso' ? kaso : hp;
                await Promise.all(rows.map(deleteServerRow));
                if (which === 'jual') { jual = []; renderJual(); }
                if (which === 'kaso') { kaso = []; renderKas(); }
                if (which === 'hp') { hp = []; renderHP(); }
                setFeedback('Semua data pada buku berhasil dihapus.');
            } catch (error) { setFeedback(error.message, true); }
        }

        async function tambahJual() {
            const tanggal = document.getElementById('j-tanggal').value;
            const produk = document.getElementById('j-produk').value.trim();
            const qty = Number(document.getElementById('j-qty').value);
            const harga = Number(document.getElementById('j-harga').value);
            if (!tanggal || !produk || qty <= 0 || harga <= 0 || !Number.isFinite(qty) || !Number.isFinite(harga)) { window.alert('Lengkapi semua kolom terlebih dahulu.'); return; }
            try {
                const row = { id: Date.now(), tanggal, produk, qty, harga, contoh: false };
                if (isAuthenticated) jual.push(await createTransaction({ book_type: 'jual', date: tanggal, title_or_product: produk, qty, price_per_unit: harga, amount: qty * harga, transaction_type: 'masuk', status: 'lunas' }));
                else { jual.push(row); localSet('jual', jual); }
                document.getElementById('j-produk').value = '';
                document.getElementById('j-qty').value = '';
                document.getElementById('j-harga').value = '';
                renderJual();
                setFeedback('Penjualan berhasil disimpan.');
            } catch (error) { setFeedback(error.message, true); }
        }

        async function hapusJual(id) {
            if (!confirmDelete('Hapus transaksi penjualan ini?')) return;
            try { const row = jual.find(item => String(item.id) === String(id)); if (isAuthenticated) await deleteServerRow(row); jual = jual.filter(item => String(item.id) !== String(id)); if (!isAuthenticated) localSet('jual', jual); renderJual(); } catch (error) { setFeedback(error.message, true); }
        }

        async function tambahKas() {
            const tanggal = document.getElementById('k-tanggal').value;
            const ket = document.getElementById('k-ket').value.trim();
            const kategori = document.getElementById('k-kategori').value;
            const jenis = document.getElementById('k-jenis').value;
            const jumlah = Number(document.getElementById('k-jumlah').value);
            if (!tanggal || !ket || !jumlah || jumlah <= 0) { window.alert('Lengkapi tanggal, keterangan, dan jumlah terlebih dahulu.'); return; }
            try {
                const row = { id: Date.now(), tanggal, ket, kategori, jenis, jumlah, contoh: false };
                if (isAuthenticated) kaso.push(await createTransaction({ book_type: 'kaso', date: tanggal, title_or_product: ket, category: kategori, transaction_type: jenis, amount: jumlah }));
                else { kaso.push(row); localSet('kaso', kaso); }
                document.getElementById('k-ket').value = '';
                document.getElementById('k-jumlah').value = '';
                renderKas();
                setFeedback('Transaksi kas berhasil disimpan.');
            } catch (error) { setFeedback(error.message, true); }
        }

        async function hapusKas(id) {
            if (!confirmDelete('Hapus transaksi kas ini?')) return;
            try { const row = kaso.find(item => String(item.id) === String(id)); if (isAuthenticated) await deleteServerRow(row); kaso = kaso.filter(item => String(item.id) !== String(id)); if (!isAuthenticated) localSet('kaso', kaso); renderKas(); } catch (error) { setFeedback(error.message, true); }
        }

        async function tambahHP() {
            const tanggal = document.getElementById('h-tanggal').value;
            const jenis = document.getElementById('h-jenis').value;
            const nama = document.getElementById('h-nama').value.trim();
            const jumlah = Number(document.getElementById('h-jumlah').value);
            const ket = document.getElementById('h-ket').value.trim();
            if (!tanggal || !nama || !jumlah || jumlah <= 0) { window.alert('Lengkapi tanggal, nama, dan jumlah terlebih dahulu.'); return; }
            try {
                const row = { id: Date.now(), tanggal, jenis, nama, jumlah, ket, status: 'belum', contoh: false };
                if (isAuthenticated) hp.push(await createTransaction({ book_type: 'hp', date: tanggal, title_or_product: nama, category: jenis, transaction_type: jenis, amount: jumlah, status: 'belum', notes: ket }));
                else { hp.push(row); localSet('hp', hp); }
                document.getElementById('h-nama').value = '';
                document.getElementById('h-jumlah').value = '';
                document.getElementById('h-ket').value = '';
                renderHP();
                setFeedback('Catatan utang/piutang berhasil disimpan.');
            } catch (error) { setFeedback(error.message, true); }
        }

        async function toggleLunas(id) {
            const index = hp.findIndex(item => String(item.id) === String(id));
            if (index < 0) return;
            try {
                if (isAuthenticated) hp[index] = normalizeServerTransaction((await serverRequest(apiUrl(transactionUrls.toggle, hp[index].id), { method: 'PATCH' })).data);
                else { hp[index].status = hp[index].status === 'lunas' ? 'belum' : 'lunas'; localSet('hp', hp); }
                renderHP();
            } catch (error) { setFeedback(error.message, true); }
        }

        async function hapusHP(id) {
            if (!confirmDelete('Hapus catatan utang/piutang ini?')) return;
            try { const row = hp.find(item => String(item.id) === String(id)); if (isAuthenticated) await deleteServerRow(row); hp = hp.filter(item => String(item.id) !== String(id)); if (!isAuthenticated) localSet('hp', hp); renderHP(); } catch (error) { setFeedback(error.message, true); }
        }

        function exportCSV(which) {
            let rows;
            let filename;
            if (which === 'jual') {
                rows = [['Tanggal', 'Produk', 'Qty', 'Harga Satuan', 'Total']];
                [...jual].sort((a, b) => a.tanggal.localeCompare(b.tanggal)).forEach(row => rows.push([fmtTgl(row.tanggal), row.produk, row.qty, row.harga, row.qty * row.harga]));
                filename = 'buku-penjualan.csv';
            } else if (which === 'kaso') {
                rows = [['Tanggal', 'Keterangan', 'Kategori', 'Jenis', 'Jumlah']];
                [...kaso].sort((a, b) => a.tanggal.localeCompare(b.tanggal)).forEach(row => rows.push([fmtTgl(row.tanggal), row.ket, row.kategori, row.jenis === 'masuk' ? 'Kas Masuk' : 'Kas Keluar', row.jumlah]));
                filename = 'buku-kas-operasional.csv';
            } else {
                rows = [['Tanggal', 'Nama', 'Jenis', 'Keterangan', 'Jumlah', 'Status']];
                [...hp].sort((a, b) => a.tanggal.localeCompare(b.tanggal)).forEach(row => rows.push([fmtTgl(row.tanggal), row.nama, row.jenis === 'piutang' ? 'Piutang' : 'Hutang', row.ket || '', row.jumlah, row.status === 'lunas' ? 'Lunas' : 'Belum Lunas']));
                filename = 'utang-piutang.csv';
            }
            const csv = rows.map(row => row.map(value => `"${String(value).replace(/"/g, '""')}"`).join(',')).join('\n');
            const link = document.createElement('a');
            link.href = URL.createObjectURL(new Blob([`\uFEFF${csv}`], { type: 'text/csv;charset=utf-8;' }));
            link.download = filename;
            link.click();
            URL.revokeObjectURL(link.href);
        }

        function initializeBook() {
            ['j-tanggal', 'k-tanggal', 'h-tanggal'].forEach(id => { document.getElementById(id).value = todayISO(); });
            if (isAuthenticated) {
                loadServerRows().then(() => { renderJual(); renderKas(); renderHP(); }).catch(error => setFeedback(error.message, true));
            } else {
                jual = localGet('jual', seedJual);
                kaso = localGet('kaso', seedKaso);
                hp = localGet('hp', seedHP);
                renderJual();
                renderKas();
                renderHP();
            }
        }

        initializeBook();
    </script>
@endsection