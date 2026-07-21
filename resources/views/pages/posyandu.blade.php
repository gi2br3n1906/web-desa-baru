@extends('layouts.app')

@section('title', 'Jadwal Posyandu | Desa Pringanom')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Kesehatan Masyarakat</p>
            <h1 class="page-heading mt-2">Jadwal & Informasi Posyandu</h1>
            <p class="mt-4 leading-7 text-slate-600">Catat jadwal pelayanan Posyandu dan simak informasi Perilaku Hidup Bersih dan Sehat (PHBS).</p>
        </header>

        <div class="mt-10 space-y-7">
            @forelse ($schedules as $schedule)
                <article class="grid overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:grid-cols-[15rem_1fr]">
                    <div class="flex flex-col justify-center bg-desaBlue p-6 text-white">
                        <span class="text-sm font-bold uppercase tracking-wider text-desaYellow">Jadwal Pelaksanaan</span>
                        <time datetime="{{ $schedule->tanggal_pelaksanaan->toDateString() }}" class="mt-3 text-2xl font-black">{{ $schedule->tanggal_pelaksanaan->translatedFormat('d F Y') }}</time>
                        <p class="mt-2 font-semibold text-blue-100">{{ substr($schedule->jam_mulai, 0, 5) }}–{{ substr($schedule->jam_selesai, 0, 5) }} WIB</p>
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