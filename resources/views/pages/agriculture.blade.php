@extends('layouts.app')

@section('title', 'Panduan Alat Tani | Desa Pringanom')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Pertanian Desa</p>
            <h1 class="page-heading mt-2">Panduan Perawatan Alat Tani</h1>
            <p class="mt-4 leading-7 text-slate-600">Rawat peralatan pertanian secara rutin dan ikuti petunjuk keselamatan saat menggunakannya.</p>
        </header>

        <div class="mt-10 space-y-8">
            @forelse ($guides as $guide)
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
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
                    </div>
                </article>
            @empty
                <div class="empty-state">Panduan alat pertanian belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection