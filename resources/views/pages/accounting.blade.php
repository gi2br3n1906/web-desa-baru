@extends('layouts.app')

@section('title', 'Template Pembukuan | Portal Informasi Desa')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Akuntansi UMKM</p>
            <h1 class="page-heading mt-2">Template Pembukuan Sederhana</h1>
            <p class="mt-4 leading-7 text-slate-600">Unduh format Excel untuk membantu pencatatan keuangan UMKM dan kelompok tani secara lebih tertib.</p>
        </header>

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($templates as $template)
                <article class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex size-12 items-center justify-center rounded-xl bg-green-100 font-black text-green-700">XLS</span>
                    <h2 class="mt-5 text-xl font-bold text-desaBlue">{{ $template->nama_template }}</h2>
                    <p class="mt-3 flex-1 leading-7 text-slate-600">{{ $template->deskripsi }}</p>
                    <a href="{{ asset('storage/'.$template->file_path) }}" class="mt-6 inline-flex items-center justify-center rounded-xl bg-desaYellow px-5 py-3 font-bold text-desaBlue transition hover:bg-desaYellow-dark focus:outline-none focus:ring-2 focus:ring-desaBlue" download>Unduh Template</a>
                </article>
            @empty
                <div class="empty-state md:col-span-2 lg:col-span-3">Template pembukuan belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection