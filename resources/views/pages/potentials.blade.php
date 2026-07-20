@extends('layouts.app')

@section('title', 'Potensi Desa Bilingual | Portal Informasi Desa')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Indonesia ・ 日本語</p>
            <h1 class="page-heading mt-2">Potensi Desa Bilingual</h1>
            <p class="mt-4 leading-7 text-slate-600">Mengenalkan kekayaan dan potensi unggulan desa dalam Bahasa Indonesia dan Bahasa Jepang.</p>
        </header>

        <div class="mt-10 space-y-10">
            @forelse ($potentials as $potential)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    @if ($potential->image_path)
                        <img src="{{ asset('storage/'.$potential->image_path) }}" alt="{{ $potential->title_id }}" class="h-64 w-full object-cover sm:h-80" loading="lazy">
                    @endif
                    <div class="grid divide-y divide-slate-200 lg:grid-cols-2 lg:divide-x lg:divide-y-0">
                        <section class="p-6 sm:p-8" lang="id">
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-desaBlue">Indonesia</span>
                            <h2 class="mt-4 text-2xl font-bold text-desaBlue">{{ $potential->title_id }}</h2>
                            <div class="rich-content mt-6">{!! $potential->content_id !!}</div>
                        </section>
                        <section class="p-6 sm:p-8" lang="ja">
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-red-700">日本語</span>
                            <h2 class="mt-4 text-2xl font-bold text-slate-900">{{ $potential->title_jp }}</h2>
                            <div class="rich-content mt-6">{!! $potential->content_jp !!}</div>
                        </section>
                    </div>
                </article>
            @empty
                <div class="empty-state">Informasi potensi desa belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection