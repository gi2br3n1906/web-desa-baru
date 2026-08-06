@extends('layouts.app')

@section('title', $article->title.' | Kabar Desa')

@section('content')
    <article class="page-container">
        <div class="mx-auto max-w-4xl">
            <a href="{{ route('news.index') }}" class="inline-flex items-center font-bold text-blue-900 hover:text-amber-700"><span class="mr-2" aria-hidden="true">←</span> Kembali ke Kabar Desa</a>
            <div class="mt-8">
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-black text-amber-800">{{ $article->category }}</span>
                <h1 class="mt-5 text-3xl font-black leading-tight text-blue-950 sm:text-5xl">{{ $article->title }}</h1>
                <p class="mt-5 text-sm font-semibold text-slate-500">{{ $article->published_at->translatedFormat('d F Y, H:i') }} · Ditulis oleh {{ $article->author_name }}</p>
            </div>

            <x-smart-image :src="$article->thumbnail_path ? asset('storage/'.$article->thumbnail_path) : null" :alt="$article->title" class="mt-8 aspect-[16/8] rounded-2xl" :eager="true" />

            <div class="rich-content mt-10 max-w-none text-base leading-8">{!! $article->content !!}</div>
        </div>
    </article>

    <section class="border-t border-slate-200 bg-white" aria-labelledby="related-news-heading">
        <div class="page-container">
            <h2 id="related-news-heading" class="text-2xl font-black text-blue-900">Berita Terkait</h2>
            @if ($relatedArticles->isNotEmpty())
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedArticles as $related)
                        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <span class="text-xs font-black uppercase tracking-wide text-amber-700">{{ $related->category }}</span>
                            <h3 class="mt-3 text-lg font-black leading-6 text-blue-900"><a href="{{ route('news.show', $related->slug) }}" class="hover:text-amber-700">{{ $related->title }}</a></h3>
                            <p class="mt-2 text-xs font-semibold text-slate-500">{{ $related->published_at->translatedFormat('d F Y') }}</p>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="mt-4 text-slate-600">Belum ada berita terkait pada kategori ini.</p>
            @endif
        </div>
    </section>
@endsection