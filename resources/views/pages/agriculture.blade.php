@extends('layouts.app')

@section('title', 'Panduan Alat Tani | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Pertanian Desa" title="Panduan Perawatan Alat Tani" description="Rawat peralatan pertanian secara rutin dan ikuti petunjuk keselamatan saat menggunakannya." />

        <div class="mt-10 space-y-8">
            @forelse ($guides as $guide)
                <article class="content-card overflow-hidden">
                    @php
                        $tractorImage = \App\Support\BrandAssets::image('alat-tani-traktor');
                    @endphp
                    <x-smart-image :src="$tractorImage ? asset($tractorImage) : null" alt="Traktor membajak sawah Desa Pringanom" class="aspect-video w-full" />
                    <p class="border-b border-slate-100 bg-slate-50 px-6 py-3 text-sm text-slate-500">Panduan RichEditor di bawah mendukung embed video YouTube traktor membajak sawah.</p>
                    <div class="p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-desaBlue">{{ $guide->nama_alat }}</h2>
                    <div class="mt-7 grid gap-8 lg:grid-cols-2">
                        <section>
                            <h3 class="border-l-4 border-desaYellow pl-3 text-lg font-bold text-desaBlue">Panduan Perawatan</h3>
                            <div class="rich-content mt-5">{!! $guide->panduan_perawatan !!}</div>
                        </section>
                        <section class="rounded-xl bg-yellow-50 p-5 ring-1 ring-yellow-200">
                            <h3 class="text-lg font-bold text-yellow-900">Tips Keamanan</h3>
                            <div class="rich-content mt-5">{!! $guide->tips_keamanan !!}</div>
                        </section>
                    </div></div>
                </article>
            @empty
                <div class="empty-state">Panduan alat pertanian belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection