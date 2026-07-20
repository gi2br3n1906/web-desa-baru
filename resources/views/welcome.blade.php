@extends('layouts.app')

@section('title', 'Beranda | Portal Informasi Desa')

@section('content')
    <section class="relative isolate overflow-hidden bg-desaBlue text-white">
        <div class="absolute inset-0 -z-10 opacity-20" aria-hidden="true">
            <div class="absolute -right-24 -top-24 size-96 rounded-full bg-desaYellow blur-3xl"></div>
            <div class="absolute -bottom-32 -left-24 size-96 rounded-full bg-blue-300 blur-3xl"></div>
        </div>

        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-28">
            <div>
                <span class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-desaYellow ring-1 ring-white/20">Informasi desa dalam satu portal</span>
                <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl">Selamat Datang di Portal Informasi Desa</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-blue-100">Temukan layanan administrasi, profil pemerintahan, fasilitas publik, jadwal kesehatan, panduan pertanian, dan dukungan UMKM secara mudah dan transparan.</p>
                <div class="mt-9 flex flex-wrap gap-4">
                    <a href="{{ route('services') }}" class="rounded-xl bg-desaYellow px-6 py-3 font-bold text-desaBlue shadow-lg transition hover:bg-desaYellow-dark focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-desaBlue">Lihat Layanan Desa</a>
                    <a href="{{ route('profile') }}" class="rounded-xl border border-white/40 bg-white/10 px-6 py-3 font-bold text-white transition hover:bg-white hover:text-desaBlue focus:outline-none focus:ring-2 focus:ring-desaYellow">Kenali Desa Kami</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4" aria-label="Ringkasan layanan portal">
                @foreach ([
                    ['Pemerintahan', 'Profil dan informasi perangkat desa'],
                    ['Pelayanan', 'Panduan administrasi yang jelas'],
                    ['Kesehatan', 'Jadwal Posyandu dan informasi PHBS'],
                    ['UMKM', 'Pembukuan dan panduan perpajakan'],
                ] as [$title, $description])
                    <article class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm transition hover:-translate-y-1 hover:bg-white/15">
                        <div class="mb-4 size-2 rounded-full bg-desaYellow"></div>
                        <h2 class="font-bold text-white">{{ $title }}</h2>
                        <p class="mt-2 text-sm leading-6 text-blue-100">{{ $description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-container" aria-labelledby="explore-heading">
        <div class="max-w-2xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Jelajahi informasi</p>
            <h2 id="explore-heading" class="page-heading mt-2">Layanan untuk masyarakat desa</h2>
            <p class="mt-4 leading-7 text-slate-600">Portal ini menghubungkan masyarakat dengan informasi penting yang dikelola langsung oleh pemerintah desa.</p>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                [route('services'), 'Administrasi & Hukum', 'Persyaratan dan alur pengurusan layanan desa.'],
                [route('facilities'), 'Fasilitas Desa', 'Lokasi dan keterangan fasilitas publik desa.'],
                [route('agriculture'), 'Panduan Alat Tani', 'Perawatan dan keselamatan penggunaan alat pertanian.'],
                [route('posyandu'), 'Informasi Posyandu', 'Jadwal kegiatan dan informasi kesehatan masyarakat.'],
            ] as [$url, $title, $description])
                <a href="{{ $url }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-desaYellow hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-desaBlue">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-blue-50 font-black text-desaBlue transition group-hover:bg-desaYellow">→</span>
                    <h3 class="mt-5 text-lg font-bold text-desaBlue">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endsection