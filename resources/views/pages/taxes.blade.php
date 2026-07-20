@extends('layouts.app')

@section('title', 'Panduan Pajak UMKM | Portal Informasi Desa')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Akuntansi Perpajakan</p>
            <h1 class="page-heading mt-2">Panduan Pajak UMKM</h1>
            <p class="mt-4 leading-7 text-slate-600">Pahami gambaran alur administrasi dan informasi tarif pajak berdasarkan kategori usaha.</p>
        </header>

        <div class="mt-10 grid gap-7 lg:grid-cols-2">
            @forelse ($guides as $guide)
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
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