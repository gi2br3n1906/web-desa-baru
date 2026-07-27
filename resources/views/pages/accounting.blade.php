@extends('layouts.app')

@section('title', 'Template Pembukuan | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Akuntansi UMKM" title="Template Pembukuan Sederhana" description="Unduh format Excel untuk membantu pencatatan keuangan UMKM dan kelompok tani secara lebih tertib." />

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($templates as $template)
                <article class="content-card flex flex-col p-6 hover:-translate-y-1">
                    <span class="flex size-12 items-center justify-center rounded-xl bg-green-100 font-black text-green-700">XLS</span>
                    <h2 class="mt-5 text-xl font-bold text-desaBlue">{{ $template->nama_template }}</h2>
                    <p class="mt-3 flex-1 leading-7 text-slate-600">{{ $template->deskripsi }}</p>
                    <a href="{{ asset('storage/'.$template->file_path) }}" class="primary-button mt-6" download>Unduh Template</a>
                </article>
            @empty
                <div class="empty-state md:col-span-2 lg:col-span-3">Template pembukuan belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection