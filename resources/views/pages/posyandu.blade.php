@extends('layouts.app')

@section('title', 'Jadwal Posyandu | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Kesehatan Masyarakat" title="Jadwal & Informasi Posyandu" description="Catat jadwal pelayanan Posyandu dan simak informasi Perilaku Hidup Bersih dan Sehat (PHBS)." />

        @php
            $toddler = \App\Support\BrandAssets::image('posyandu-balita');
        @endphp
        <x-smart-image :src="$toddler ? asset($toddler) : null" alt="Balita mengikuti pelayanan Posyandu Desa Pringanom" class="mt-10 aspect-video w-full rounded-2xl" />

        <div class="mt-10 space-y-7">
            @forelse ($schedules as $schedule)
                <article class="content-card grid overflow-hidden md:grid-cols-[15rem_1fr]">
                    <div class="flex flex-col justify-center bg-blue-50 p-6 text-blue-900">
                        <span class="text-sm font-bold uppercase tracking-wider text-amber-600">Jadwal Pelaksanaan</span>
                        <time datetime="{{ $schedule->tanggal_pelaksanaan->toDateString() }}" class="mt-3 text-2xl font-black">{{ $schedule->tanggal_pelaksanaan->translatedFormat('d F Y') }}</time>
                        <p class="mt-2 font-semibold text-slate-600">{{ substr($schedule->jam_mulai, 0, 5) }}–{{ substr($schedule->jam_selesai, 0, 5) }} WIB</p>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <h2 class="text-2xl font-bold text-desaBlue">{{ $schedule->nama_posyandu }}</h2>
                            <span class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-900">Bidan: {{ $schedule->kontak_bidan }}</span>
                        </div>
                        <h3 class="mt-6 border-l-4 border-desaYellow pl-3 font-bold text-desaBlue">Informasi PHBS</h3>
                        <div class="rich-content mt-5">{!! $schedule->informasi_phbs !!}</div>
                    </div>
                </article>
            @empty
                <div class="empty-state">Jadwal Posyandu belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection