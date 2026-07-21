@extends('layouts.app')

@section('title', 'Layanan Administrasi | Desa Pringanom')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Administrasi & Hukum</p>
            <h1 class="page-heading mt-2">Panduan Layanan Desa</h1>
            <p class="mt-4 leading-7 text-slate-600">Persiapkan dokumen dan pahami alur pengurusan sebelum datang ke kantor desa.</p>
        </header>

        <div class="mt-10 space-y-8">
            @forelse ($services as $service)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <header class="bg-desaBlue px-6 py-5 text-white sm:px-8"><h2 class="text-xl font-bold sm:text-2xl">{{ $service->nama_layanan }}</h2></header>
                    <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-2">
                        <section>
                            <h3 class="border-l-4 border-desaYellow pl-3 text-lg font-bold text-desaBlue">Persyaratan</h3>
                            <div class="rich-content mt-5">{!! $service->persyaratan !!}</div>
                        </section>
                        <section>
                            <h3 class="border-l-4 border-desaYellow pl-3 text-lg font-bold text-desaBlue">Alur Pengurusan</h3>
                            <div class="rich-content mt-5">{!! $service->alur_pengurusan !!}</div>
                        </section>
                    </div>
                </article>
            @empty
                <div class="empty-state">Panduan layanan belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection