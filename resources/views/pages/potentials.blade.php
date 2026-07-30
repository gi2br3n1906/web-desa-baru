@extends('layouts.app')

@section('title', 'Potensi Desa Bilingual | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Indonesia ・ 日本語" title="Potensi Desa Bilingual" description="Mengenalkan kekayaan dan potensi unggulan desa dalam Bahasa Indonesia dan Bahasa Jepang." />

        <div class="mt-10 space-y-10">
            @forelse ($potentials as $potential)
                <article class="content-card overflow-hidden">
                    @php
                        $kite = \App\Support\BrandAssets::image('potensi-layangan');
                    @endphp
                    <x-smart-image :src="$potential->image_path ? asset('storage/'.$potential->image_path) : ($kite ? asset($kite) : null)" :alt="'Anak-anak bermain layangan, potensi sosial Desa Pringanom — '.$potential->title_id" class="aspect-video w-full" />
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