@extends('layouts.app')

@section('title', 'Fasilitas Desa | Desa Pringanom')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Fasilitas Publik</p>
            <h1 class="page-heading mt-2">Peta Fasilitas Desa</h1>
            <p class="mt-4 leading-7 text-slate-600">Temukan kantor, sekolah, tempat ibadah, fasilitas kesehatan, dan infrastruktur desa.</p>
        </header>

        <div class="mt-10 grid gap-8 lg:grid-cols-2">
            @forelse ($facilities as $facility)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    @if ($facility->google_maps_embed)
                        <div class="aspect-video overflow-hidden bg-slate-100 [&_iframe]:h-full [&_iframe]:w-full [&_iframe]:border-0">{!! $facility->google_maps_embed !!}</div>
                    @else
                        <div class="flex aspect-video items-center justify-center bg-blue-50 text-center text-desaBlue"><span class="font-semibold">Peta lokasi belum tersedia</span></div>
                    @endif
                    <div class="p-6">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <h2 class="text-xl font-bold text-desaBlue">{{ $facility->nama_fasilitas }}</h2>
                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-yellow-800">{{ $facility->kategori }}</span>
                        </div>
                        @if ($facility->keterangan)<p class="mt-4 leading-7 text-slate-600">{{ $facility->keterangan }}</p>@endif
                    </div>
                </article>
            @empty
                <div class="empty-state lg:col-span-2">Informasi fasilitas desa belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection