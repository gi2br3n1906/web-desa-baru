@extends('layouts.app')

@section('title', 'Layanan Administrasi | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Administrasi & Hukum" title="Panduan Layanan Desa" description="Persiapkan dokumen dan pahami alur pengurusan sebelum datang ke kantor desa." />

        <div class="mt-10 space-y-8">
            @forelse ($services as $service)
                <article class="content-card overflow-hidden">
                    <header class="border-b border-slate-100 bg-blue-50 px-6 py-5 sm:px-8"><h2 class="text-xl font-bold text-blue-900 sm:text-2xl">{{ $service->nama_layanan }}</h2></header>
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