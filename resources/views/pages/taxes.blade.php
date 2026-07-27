@extends('layouts.app')

@section('title', 'Panduan Pajak UMKM | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Akuntansi Perpajakan" title="Panduan Pajak UMKM" description="Pahami gambaran alur administrasi dan informasi tarif pajak berdasarkan kategori usaha." />

        <div class="mt-10 grid gap-7 lg:grid-cols-2">
            @forelse ($guides as $guide)
                <article class="content-card p-6 sm:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <h2 class="text-2xl font-bold text-desaBlue">{{ $guide->kategori_umkm }}</h2>
                        <span class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-bold text-yellow-900">{{ $guide->tarif_informasi }}</span>
                    </div>
                    <h3 class="mt-7 border-l-4 border-desaYellow pl-3 font-bold text-desaBlue">Alur Administrasi Pajak</h3>
                    <div class="rich-content mt-5">{!! $guide->alur_pajak !!}</div>
                </article>
            @empty
                <div class="empty-state lg:col-span-2">Panduan pajak UMKM belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection