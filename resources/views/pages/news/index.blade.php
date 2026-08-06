@extends('layouts.app')

@section('title', 'Kabar Desa | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Informasi Terkini" title="Kabar Desa" description="Berita, kegiatan, dan pengumuman resmi Desa Pringanom untuk seluruh warga." />

        <form method="GET" action="{{ route('news.index') }}" x-data class="mt-10 grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-[minmax(0,1fr)_14rem_auto]">
            <label>
                <span class="text-sm font-bold text-slate-700">Cari berita</span>
                <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul atau isi berita..." @input.debounce.400ms="$event.target.form.requestSubmit()" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 shadow-sm placeholder:text-slate-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500">
            </label>
            <label>
                <span class="text-sm font-bold text-slate-700">Kategori</span>
                <select name="category" @change="$event.target.form.requestSubmit()" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected($activeCategory === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </label>
            <div class="flex items-end gap-2">
                <button type="submit" class="primary-button w-full">Cari</button>
                @if ($search || $activeCategory)
                    <a href="{{ route('news.index') }}" class="inline-flex h-[2.875rem] items-center rounded-xl border border-slate-300 px-4 font-bold text-slate-600 hover:bg-slate-50">Reset</a>
                @endif
            </div>
        </form>

        <div class="mt-8 flex items-center justify-between gap-4">
            <p class="text-sm text-slate-500">Menampilkan {{ $articles->total() }} berita</p>
            @if ($activeCategory)<span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-900">{{ $activeCategory }}</span>@endif
        </div>

        <div class="mt-5 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-amber-400 hover:shadow-lg">
                    <x-smart-image :src="$article->thumbnail_path ? asset('storage/'.$article->thumbnail_path) : null" :alt="$article->title" class="aspect-[16/9]" />
                    <div class="p-5">
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-black text-amber-800">{{ $article->category }}</span>
                        <h2 class="mt-4 text-xl font-black leading-7 text-blue-900"><a href="{{ route('news.show', $article->slug) }}" class="hover:text-amber-700">{{ $article->title }}</a></h2>
                        <p class="mt-3 text-xs font-semibold text-slate-500">{{ $article->published_at->translatedFormat('d F Y') }} · {{ $article->author_name }}</p>
                        <p class="mt-4 line-clamp-3 leading-6 text-slate-600">{{ $article->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 160) }}</p>
                        <a href="{{ route('news.show', $article->slug) }}" class="mt-5 inline-flex items-center font-bold text-blue-900 hover:text-amber-700">Baca selengkapnya <span class="ml-2" aria-hidden="true">→</span></a>
                    </div>
                </article>
            @empty
                <div class="empty-state md:col-span-2 lg:col-span-3">Belum ada berita yang sesuai dengan pencarian.</div>
            @endforelse
        </div>

        @if ($articles->hasPages())
            <div class="mt-10">{{ $articles->onEachSide(1)->links() }}</div>
        @endif
    </section>
@endsection