@extends('layouts.app')

@section('title', 'Profil Desa | Desa Pringanom')

@section('content')
    <section class="page-container">
        <header class="max-w-3xl">
            <p class="font-bold uppercase tracking-wider text-yellow-600">Pemerintahan Desa</p>
            <h1 class="page-heading mt-2">Profil Pemerintah Desa Pringanom</h1>
            <p class="mt-4 leading-7 text-slate-600">Kenali arah pembangunan, misi pelayanan, struktur organisasi, serta kontak resmi Pemerintah Desa Pringanom.</p>
        </header>

        @if ($profile)
            <div class="mt-10 grid gap-8 lg:grid-cols-2">
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="border-l-4 border-desaYellow pl-4 text-2xl font-bold text-desaBlue">Visi</h2>
                    <div class="rich-content mt-6">{!! $profile->visi !!}</div>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="border-l-4 border-desaYellow pl-4 text-2xl font-bold text-desaBlue">Misi</h2>
                    <div class="rich-content mt-6">{!! $profile->misi !!}</div>
                </article>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-3">
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
                    <div class="border-b border-slate-100 p-6"><h2 class="text-2xl font-bold text-desaBlue">Struktur Organisasi</h2></div>
                    <img src="{{ asset('storage/'.$profile->struktur_organisasi_path) }}" alt="Struktur organisasi Pemerintah Desa Pringanom" class="h-auto w-full object-contain p-4" loading="lazy">
                </article>

                <aside class="rounded-2xl bg-desaBlue p-6 text-white shadow-sm">
                    <h2 class="text-xl font-bold text-desaYellow">Kontak Desa</h2>
                    <dl class="mt-6 space-y-5">
                        @forelse ($profile->kontak_desa ?? [] as $type => $value)
                            <div class="border-b border-white/15 pb-4 last:border-0">
                                <dt class="text-sm font-semibold uppercase tracking-wide text-blue-200">{{ $type }}</dt>
                                <dd class="mt-1 break-words font-medium text-white">{{ $value }}</dd>
                            </div>
                        @empty
                            <p class="text-blue-100">Informasi kontak belum tersedia.</p>
                        @endforelse
                    </dl>
                </aside>
            </div>
        @else
            <div class="empty-state mt-10">Profil desa belum dipublikasikan oleh administrator.</div>
        @endif
    </section>
@endsection