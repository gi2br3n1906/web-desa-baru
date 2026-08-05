@extends('layouts.app')

@section('title', 'Informasi Posyandu | Desa Pringanom')

@section('content')
    <style>[x-cloak] { display: none !important; }</style>

    <div x-data="posyanduPage()" class="bg-slate-50">
        {{-- Section 1: hero and responsible midwife --}}
        <section class="border-b border-slate-200 bg-white">
            <div class="page-container pb-10 pt-12 lg:pb-14 lg:pt-16">
                <div class="max-w-3xl">
                    <p class="section-kicker">Kesehatan Masyarakat</p>
                    <h1 class="page-heading mt-5">Informasi Posyandu Desa Pringanom</h1>
                    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Informasi kader, edukasi kesehatan, dan dokumentasi kegiatan Posyandu di wilayah Desa Pringanom.</p>
                </div>

                <article class="mt-10 overflow-hidden rounded-2xl bg-blue-900 shadow-xl">
                    <div class="grid lg:grid-cols-[minmax(16rem,0.8fr)_minmax(0,1.6fr)]">
                        <div class="flex min-h-64 items-center justify-center bg-blue-950 p-8">
                            @if ($posyanduProfile?->foto_path)
                                <img src="{{ asset('storage/'.$posyanduProfile->foto_path) }}" alt="Foto Bidan {{ $posyanduProfile->nama_bidan }}" class="size-44 rounded-full border-8 border-white/20 object-cover shadow-2xl">
                            @else
                                <div class="flex size-44 items-center justify-center rounded-full border-8 border-white/15 bg-amber-500 text-5xl font-black text-blue-950 shadow-2xl" role="img" aria-label="Avatar Bidan Iis Nurdianawati">IN</div>
                            @endif
                        </div>
                        <div class="p-7 text-white sm:p-10">
                            <span class="inline-flex rounded-full bg-amber-500 px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-blue-950">Penanggung Jawab Posyandu</span>
                            <p class="mt-5 text-sm font-bold uppercase tracking-[0.14em] text-blue-200">{{ $posyanduProfile?->subtitle ?? 'Bidan Desa — Penanggung Jawab & Pembina Seluruh Kader Posyandu' }}</p>
                            <h2 class="mt-3 text-3xl font-black sm:text-4xl">Bidan {{ $posyanduProfile?->nama_bidan ?? 'Iis Nurdianawati' }}</h2>
                            <p class="mt-3 font-semibold text-amber-300">{{ $posyanduProfile?->wilayah ?? 'Desa Pringanom, Kec. Masaran' }}</p>
                            <p class="mt-6 max-w-2xl text-base leading-7 text-blue-100">{{ $posyanduProfile?->deskripsi ?? 'Bidan yang bertanggung jawab membina dan mendampingi seluruh kader posyandu di wilayah Desa Pringanom.' }}</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- Section 2: village-wide hierarchy of Posyandu cadres --}}
        <section class="page-container" aria-labelledby="struktur-posyandu-heading">
            <div class="max-w-3xl">
                <p class="section-kicker">Kader &amp; Kepengurusan</p>
                <h2 id="struktur-posyandu-heading" class="mt-4 text-3xl font-black text-blue-900">Struktur Pengurus &amp; Kader Posyandu Desa Pringanom</h2>
                <p class="mt-3 leading-7 text-slate-600">Susunan Kepengurusan Kader Kesehatan &amp; Posyandu Desa Pringanom.</p>
            </div>

            @php
                $chair = $officers->firstWhere('jabatan', 'Ketua');
                $coreOfficers = $officers->whereIn('level', [2]);
                $fieldOfficers = $officers->where('level', 3);
            @endphp
            <div class="relative mt-10">
                <div class="mx-auto max-w-sm">
                    @if ($chair)
                        <article class="relative rounded-2xl border-2 border-amber-400 bg-white p-5 text-center shadow-lg">
                            <span class="text-xs font-black uppercase tracking-[0.15em] text-amber-600">Ketua</span>
                            <h3 class="mt-2 text-xl font-black text-blue-900">{{ $chair->nama }}</h3>
                            <span class="mt-3 inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-900">Puncak kepengurusan</span>
                        </article>
                    @endif
                </div>

                <div class="mx-auto hidden h-10 w-px bg-slate-300 md:block" aria-hidden="true"></div>
                <div class="mx-auto grid max-w-2xl gap-5 md:grid-cols-2">
                    @foreach ($coreOfficers as $officer)
                        <article class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                            <span class="text-xs font-black uppercase tracking-[0.15em] text-blue-700">{{ $officer->jabatan }}</span>
                            <h3 class="mt-2 text-lg font-black text-slate-900">{{ $officer->nama }}</h3>
                        </article>
                    @endforeach
                </div>

                <div class="mx-auto hidden h-10 w-px bg-slate-300 md:block" aria-hidden="true"></div>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7">
                    @foreach ($fieldOfficers as $officer)
                        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-400 hover:shadow-md">
                            <span class="block text-xs font-black uppercase leading-5 tracking-wide text-blue-700">{{ $officer->jabatan }}</span>
                            <h3 class="mt-3 text-sm font-bold leading-6 text-slate-900">{{ $officer->nama }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Section 3: health education with Alpine modal --}}
        <section class="page-container" aria-labelledby="edukasi-posyandu-heading">
            <div class="max-w-3xl">
                <p class="section-kicker">Materi Kesehatan</p>
                <h2 id="edukasi-posyandu-heading" class="mt-4 text-3xl font-black text-blue-900">Infografis &amp; Edukasi Kesehatan</h2>
                <p class="mt-3 leading-7 text-slate-600">Simak materi Perilaku Hidup Bersih dan Sehat (PHBS), Gizi, dan Imunisasi.</p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($educations as $education)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-amber-400 hover:shadow-lg">
                        <button type="button" class="group block w-full text-left" @click="openPoster(@js(['title' => $education->judul, 'description' => $education->deskripsi, 'image' => $education->thumbnail_url, 'url' => $education->poster_url]))" aria-label="Lihat poster {{ $education->judul }}">
                            <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                @if ($education->thumbnail_url)
                                    <img src="{{ $education->thumbnail_url }}" alt="Poster {{ $education->judul }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center p-6 text-center text-sm font-semibold text-slate-500">Poster akan tampil setelah aset tersedia</div>
                                @endif
                                <span class="absolute left-4 top-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-black tracking-wide text-blue-950">{{ $education->kategori }}</span>
                            </div>
                            <div class="p-5">
                                <h3 class="text-xl font-black leading-7 text-blue-900">{{ $education->judul }}</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $education->deskripsi }}</p>
                                <span class="mt-5 inline-flex items-center font-bold text-blue-900">Lihat Poster <span class="ml-2 transition group-hover:translate-x-1" aria-hidden="true">→</span></span>
                            </div>
                        </button>
                    </article>
                @empty
                    <div class="empty-state md:col-span-2 lg:col-span-3">Materi edukasi kesehatan belum tersedia.</div>
                @endforelse
            </div>
        </section>

        {{-- Section 4: gallery with year filter --}}
        <section class="border-t border-slate-200 bg-white" aria-labelledby="galeri-posyandu-heading">
            <div class="page-container">
                <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="section-kicker">Dokumentasi Kegiatan</p>
                        <h2 id="galeri-posyandu-heading" class="mt-4 text-3xl font-black text-blue-900">Galeri Kegiatan Posyandu</h2>
                        <p class="mt-3 leading-7 text-slate-600">Dokumentasi foto kegiatan posyandu dari waktu ke waktu.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 rounded-xl bg-slate-100 p-1" role="group" aria-label="Filter tahun galeri">
                        <template x-for="year in years" :key="year">
                            <button type="button" @click="selectedYear = year" :class="selectedYear === year ? 'bg-blue-900 text-white shadow-sm' : 'text-slate-600 hover:bg-white'" class="rounded-lg px-4 py-2 text-sm font-bold transition" x-text="year === 'all' ? 'Semua' : year"></button>
                        </template>
                    </div>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @forelse ($galleries as $gallery)
                        <article x-show="selectedYear === 'all' || selectedYear === '{{ $gallery->tanggal->format('Y') }}'" x-transition.opacity class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <a href="{{ $gallery->foto_url }}" target="_blank" rel="noopener" class="group block" aria-label="Buka dokumentasi {{ $gallery->judul }}">
                                <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                                    @if ($gallery->thumbnail_url)
                                        <img src="{{ $gallery->thumbnail_url }}" alt="{{ $gallery->judul }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full items-center justify-center p-6 text-center text-sm font-semibold text-slate-500">Foto akan tampil setelah aset tersedia</div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3 class="font-black leading-6 text-blue-900">{{ $gallery->judul }}</h3>
                                    <time datetime="{{ $gallery->tanggal->toDateString() }}" class="mt-2 block text-sm font-semibold text-slate-500">{{ $gallery->tanggal->format('d/m/Y') }}</time>
                                </div>
                            </a>
                        </article>
                    @empty
                        <div class="empty-state sm:col-span-2 lg:col-span-4">Dokumentasi kegiatan Posyandu belum tersedia.</div>
                    @endforelse
                </div>
                <div x-show="selectedYear === '2025'" x-cloak class="empty-state mt-6">Dokumentasi tahun 2025 belum tersedia.</div>
            </div>
        </section>

        <div x-show="poster" x-cloak @keydown.escape.window="closePoster()" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-950/75 p-4" role="dialog" aria-modal="true" aria-label="Pratinjau poster">
            <div @click.outside="closePoster()" class="max-h-[92vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 p-5">
                    <div>
                        <span class="text-xs font-black uppercase tracking-[0.14em] text-amber-600">Pratinjau Poster</span>
                        <h2 class="mt-2 text-xl font-black text-blue-900" x-text="poster?.title"></h2>
                    </div>
                    <button type="button" @click="closePoster()" class="rounded-full p-2 text-2xl leading-none text-slate-500 transition hover:bg-slate-100 hover:text-blue-900" aria-label="Tutup pratinjau">&times;</button>
                </div>
                <div class="grid gap-5 p-5 sm:p-7 md:grid-cols-[minmax(0,1fr)_15rem]">
                    <div class="overflow-hidden rounded-xl bg-slate-100">
                        <img :src="poster?.image" :alt="poster?.title" class="max-h-[60vh] w-full object-contain">
                    </div>
                    <div>
                        <p class="text-sm leading-7 text-slate-600" x-text="poster?.description"></p>
                        <a :href="poster?.url" target="_blank" rel="noopener" class="primary-button mt-6 w-full">Buka Sumber Poster <span class="ml-2" aria-hidden="true">↗</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function posyanduPage() {
            return {
                selectedYear: 'all',
                years: ['all', '2026', '2025'],
                poster: null,
                openPoster(poster) { this.poster = poster; },
                closePoster() { this.poster = null; },
            };
        }
    </script>
@endsection