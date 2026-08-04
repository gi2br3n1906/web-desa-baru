@extends('layouts.app')

@section('title', 'Pojok UMKM dan Pajak | Desa Pringanom')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>[x-cloak] { display: none !important; }</style>

    @php
        $maxCategory = max(1, (int) $categoryDistribution->max());
        $maxDusun = max(1, (int) $dusunDistribution->max());
        $taxFaqs = $faqs->where('kategori', 'pajak');
        $surveyFaqs = $faqs->where('kategori', 'umkm');
    @endphp

    <div x-data="umkmPage()" class="bg-slate-50">
        {{-- Section 1: hero and quick navigation --}}
        <section class="border-b border-slate-200 bg-white">
            <div class="page-container">
                <div class="max-w-4xl">
                    <p class="section-kicker">Ekonomi Desa &amp; Literasi Pajak</p>
                    <h1 class="page-heading mt-5">Pojok UMKM dan Pajak</h1>
                    <p class="mt-5 text-lg leading-8 text-slate-600">Direktori pelaku usaha mikro, kecil, dan menengah Desa Pringanom dari hasil pendataan UMKM BPS, dilengkapi info dasar pajak untuk pelaku usaha.</p>
                </div>
                <nav class="mt-8 flex flex-wrap gap-3" aria-label="Navigasi pintas Pojok UMKM dan Pajak">
                    <a href="#direktori-umkm" class="primary-button">Lihat Direktori UMKM</a>
                    <a href="#statistik-desa" class="rounded-xl border border-blue-900 px-5 py-3 font-bold text-blue-900 transition hover:bg-blue-50">Statistik Desa</a>
                    <a href="#faq-pajak" class="rounded-xl border border-blue-900 px-5 py-3 font-bold text-blue-900 transition hover:bg-blue-50">FAQ Pajak</a>
                    <a href="#kalender-pajak" class="rounded-xl border border-blue-900 px-5 py-3 font-bold text-blue-900 transition hover:bg-blue-50">Kalender Pajak</a>
                </nav>
            </div>
        </section>

        {{-- Section 2: BPS overview --}}
        <section id="statistik-desa" class="page-container scroll-mt-24">
            <div class="overflow-hidden rounded-2xl bg-blue-950 p-6 text-white shadow-xl sm:p-8">
                <div class="flex flex-col justify-between gap-3 md:flex-row md:items-end">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.16em] text-amber-400">Sensus Ekonomi BPS 2024</p>
                        <h2 class="mt-2 text-2xl font-black sm:text-3xl">Gambaran UMKM Desa Pringanom</h2>
                    </div>
                    <p class="text-sm text-blue-200">Ringkasan pendataan resmi tingkat desa</p>
                </div>
                <div class="mt-8 grid gap-px overflow-hidden rounded-xl bg-white/15 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([['187', 'UMKM terdaftar'], ['11', 'Dukuh tercakup'], ['9', 'Rata-rata usia usaha (tahun)'], ['16', 'Berbadan usaha / kelompok']] as [$value, $label])
                        <div class="bg-blue-900/80 p-6">
                            <strong class="block text-4xl font-black text-amber-400">{{ $value }}</strong>
                            <span class="mt-2 block text-sm font-semibold leading-6 text-blue-100">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Section 3: distributions --}}
        <section class="page-container pt-0" aria-labelledby="sebaran-statistik-heading">
            <div class="max-w-3xl">
                <p class="section-kicker">Sebaran Statistik</p>
                <h2 id="sebaran-statistik-heading" class="mt-4 text-3xl font-black text-blue-900">Distribusi UMKM Desa</h2>
                <p class="mt-3 leading-7 text-slate-600">Grafik kategori dan wilayah dihitung langsung dari direktori yang tersimpan di database.</p>
            </div>
            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-black text-blue-900">Menurut Jenis Usaha</h3>
                    <div class="mt-6 space-y-4">
                        @forelse ($categoryDistribution as $label => $count)
                            <div>
                                <div class="flex justify-between gap-4 text-sm"><span class="font-semibold text-slate-700">{{ $label }}</span><span class="font-black text-blue-900">{{ $count }}</span></div>
                                <div class="mt-2 h-2.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-amber-500" style="width: {{ max(8, ($count / $maxCategory) * 100) }}%"></div></div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Data jenis usaha belum tersedia.</p>
                        @endforelse
                    </div>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-black text-blue-900">Menurut Dukuh</h3>
                    <div class="mt-6 max-h-80 space-y-4 overflow-y-auto pr-2">
                        @forelse ($dusunDistribution as $label => $count)
                            <div>
                                <div class="flex justify-between gap-4 text-sm"><span class="font-semibold text-slate-700">{{ $label }}</span><span class="font-black text-blue-900">{{ $count }}</span></div>
                                <div class="mt-2 h-2.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-blue-800" style="width: {{ max(8, ($count / $maxDusun) * 100) }}%"></div></div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Data dukuh belum tersedia.</p>
                        @endforelse
                    </div>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-black text-blue-900">Menurut Tahun Berdiri</h3>
                    <div class="mt-6 rounded-xl bg-blue-50 p-6 text-center">
                        <strong class="text-5xl font-black text-blue-900">9</strong>
                        <p class="mt-2 font-bold text-slate-700">tahun rata-rata usia usaha</p>
                    </div>
                    <p class="mt-5 text-sm leading-6 text-slate-500">Dokumen ringkasan BPS menyediakan rata-rata usia usaha. Distribusi per tahun berdiri belum tersedia pada record publik, sehingga tidak ditampilkan sebagai angka rekaan.</p>
                </article>
            </div>
        </section>

        {{-- Section 4: static and interactive maps --}}
        <section class="border-y border-slate-200 bg-white" aria-labelledby="peta-umkm-heading">
            <div class="page-container">
                <p class="section-kicker">Peta Sebaran</p>
                <h2 id="peta-umkm-heading" class="mt-4 text-3xl font-black text-blue-900">Peta Sebaran UMKM</h2>
                <p class="mt-3 max-w-3xl leading-7 text-slate-600">Lihat kartografi hasil pendataan dan jelajahi titik usaha yang memiliki koordinat pada peta interaktif.</p>

                <article class="mb-6 mt-8 rounded-2xl border border-slate-200 bg-white p-3 shadow-lg">
                    <button type="button" @click="mapPreview = true" class="group block w-full overflow-hidden rounded-xl bg-slate-100" aria-label="Lihat gambar penuh peta sebaran UMKM">
                        <img src="{{ asset('images/peta-sebaran-umkm.jpg') }}" alt="Peta kartografi sebaran UMKM Desa Pringanom" class="max-h-[42rem] w-full object-contain transition duration-300 group-hover:scale-[1.01]">
                    </button>
                    <div class="flex flex-wrap gap-3 p-3 pt-5">
                        <button type="button" @click="mapPreview = true" class="primary-button">Lihat Gambar Penuh</button>
                        <a href="{{ asset('images/peta-sebaran-umkm.jpg') }}" download class="rounded-xl border border-blue-900 px-5 py-3 font-bold text-blue-900 transition hover:bg-blue-50">Unduh Peta (JPG)</a>
                    </div>
                </article>

                <div id="map" class="h-[28rem] overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 shadow-lg" aria-label="Peta interaktif lokasi UMKM"></div>
                <span id="umkm-map" class="sr-only">Peta interaktif UMKM</span>
            </div>
        </section>

        {{-- Section 5: directory and live filters --}}
        <section id="direktori-umkm" class="page-container scroll-mt-24" aria-labelledby="direktori-umkm-heading">
            <p class="section-kicker">Katalog Usaha Warga</p>
            <h2 id="direktori-umkm-heading" class="mt-4 text-3xl font-black text-blue-900">Direktori UMKM</h2>
            <div class="mt-8 grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3">
                <label><span class="text-sm font-bold text-slate-700">Pencarian</span><input x-model="query" type="search" placeholder="Cari nama usaha atau produk..." class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 shadow-sm placeholder:text-slate-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500"></label>
                <label><span class="text-sm font-bold text-slate-700">Jenis Usaha</span><select x-model="category" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500"><option value="">Semua jenis usaha</option>@foreach($categories as $value)<option value="{{ $value }}">{{ $value }}</option>@endforeach</select></label>
                <label><span class="text-sm font-bold text-slate-700">Dukuh</span><select x-model="hamlet" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500"><option value="">Semua dukuh</option>@foreach($dusuns as $value)<option value="{{ $value }}">{{ $value }}</option>@endforeach</select></label>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($umkms as $umkm)
                    @php $searchable = strtolower($umkm->nama_umkm.' '.$umkm->deskripsi.' '.$umkm->pemilik); @endphp
                    <article x-show="matches(@js($searchable), @js($umkm->kategori), @js($umkm->dusun))" x-transition.opacity class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-amber-400 hover:shadow-lg">
                        <x-smart-image :src="$umkm->foto ? asset('storage/'.$umkm->foto) : null" :alt="'Foto UMKM '.$umkm->nama_umkm" class="aspect-video" />
                        <div class="p-5">
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-900">{{ $umkm->kategori }}</span>
                            <h3 class="mt-4 text-xl font-black text-blue-900">{{ $umkm->nama_umkm }}</h3>
                            <p class="mt-2 text-sm font-semibold text-amber-700">Dukuh {{ $umkm->dusun }}</p>
                            <p class="mt-3 line-clamp-3 leading-6 text-slate-600">{{ $umkm->deskripsi }}</p>
                        </div>
                    </article>
                @empty
                    <div class="empty-state md:col-span-2 lg:col-span-3">Data direktori UMKM belum tersedia.</div>
                @endforelse
            </div>
        </section>

        {{-- Section 6: tax FAQ --}}
        <section id="faq-pajak" class="border-y border-slate-200 bg-white scroll-mt-24" aria-labelledby="faq-pajak-heading">
            <div class="page-container">
                <p class="section-kicker">Literasi Perpajakan</p>
                <h2 id="faq-pajak-heading" class="mt-4 text-3xl font-black text-blue-900">FAQ Pajak UMKM</h2>
                <p class="mt-3 max-w-3xl leading-7 text-slate-600">Informasi dasar PPh Final UMKM, batas omzet, NIB/NPWP, dan pelaporan SPT.</p>
                <div class="mt-8 space-y-3">
                    @forelse ($taxFaqs as $faq)
                        <article x-data="{ open: false }" class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <button type="button" @click="open = !open" :aria-expanded="open" class="flex w-full items-center justify-between gap-5 p-5 text-left font-black text-blue-900 sm:p-6"><span>{{ $faq->pertanyaan }}</span><span class="text-2xl text-amber-500" x-text="open ? '−' : '+'"></span></button>
                            <div x-show="open" x-cloak class="rich-content border-t border-slate-100 px-5 pb-6 pt-5 sm:px-6">{!! $faq->jawaban !!}</div>
                        </article>
                    @empty
                        <div class="empty-state">FAQ pajak belum tersedia.</div>
                    @endforelse
                </div>
                @if ($surveyFaqs->isNotEmpty())
                    <div class="mt-10 rounded-2xl bg-blue-50 p-6 ring-1 ring-blue-100">
                        <h3 class="font-black text-blue-900">Informasi Pendataan UMKM</h3>
                        <div class="mt-4 space-y-4">
                            @foreach ($surveyFaqs as $faq)
                                <article><h4 class="font-bold text-slate-800">{{ $faq->pertanyaan }}</h4><div class="rich-content mt-2 text-sm">{!! $faq->jawaban !!}</div></article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        {{-- Section 7: tax calendar --}}
        <section id="kalender-pajak" class="page-container scroll-mt-24" aria-labelledby="kalender-pajak-heading">
            <p class="section-kicker">Agenda Wajib Pajak</p>
            <h2 id="kalender-pajak-heading" class="mt-4 text-3xl font-black text-blue-900">Kalender Kewajiban Pajak</h2>
            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[42rem] text-left">
                        <thead class="bg-blue-950 text-white"><tr><th class="px-6 py-4 font-bold">Waktu</th><th class="px-6 py-4 font-bold">Kewajiban</th><th class="px-6 py-4 font-bold">Keterangan</th></tr></thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($taxSchedules as $schedule)
                                <tr class="hover:bg-slate-50"><td class="px-6 py-4 font-black text-amber-700">{{ $schedule->is_routine_monthly ? 'Tiap Tgl '.$schedule->tanggal->format('d') : $schedule->tanggal->translatedFormat('d F') }}</td><td class="px-6 py-4 font-bold text-blue-900">{{ $schedule->judul_kegiatan }}</td><td class="px-6 py-4 text-slate-600">{{ $schedule->keterangan ?: 'Ikuti ketentuan perpajakan yang berlaku.' }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-10 text-center text-slate-500">Kalender pajak belum tersedia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <div x-show="mapPreview" x-cloak @keydown.escape.window="mapPreview = false" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/85 p-4" role="dialog" aria-modal="true" aria-label="Pratinjau peta sebaran UMKM">
            <div @click.outside="mapPreview = false" class="relative max-h-[94vh] w-full max-w-6xl overflow-auto rounded-2xl bg-white p-3 shadow-2xl">
                <button type="button" @click="mapPreview = false" class="absolute right-5 top-5 z-10 flex size-10 items-center justify-center rounded-full bg-slate-950 text-2xl text-white shadow-lg" aria-label="Tutup gambar penuh">&times;</button>
                <img src="{{ asset('images/peta-sebaran-umkm.jpg') }}" alt="Peta sebaran UMKM Desa Pringanom ukuran penuh" class="mx-auto h-auto w-full rounded-xl">
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function umkmPage() {
            return {
                query: '', category: '', hamlet: '', mapPreview: false,
                matches(searchable, category, hamlet) {
                    return (!this.query || searchable.includes(this.query.toLowerCase()))
                        && (!this.category || this.category === category)
                        && (!this.hamlet || this.hamlet === hamlet);
                },
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            const mapElement = document.getElementById('map');
            if (!mapElement || typeof L === 'undefined') return;
            const map = L.map(mapElement).setView([-7.451762, 110.92565], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
            const points = @json($umkms->filter(fn ($umkm) => $umkm->latitude && $umkm->longitude)->values());
            points.forEach((umkm) => L.marker([umkm.latitude, umkm.longitude]).addTo(map).bindPopup(`<strong>${umkm.nama_umkm}</strong><br>${umkm.kategori}<br>Dukuh ${umkm.dusun}`));
            if (points.length === 0) L.marker([-7.451762, 110.92565]).addTo(map).bindPopup('<strong>Desa Pringanom</strong><br>Titik UMKM akan tampil setelah koordinat tersedia.');
        });
    </script>
@endsection