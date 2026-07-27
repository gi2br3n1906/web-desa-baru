@extends('layouts.app')

@section('title', 'Profil Desa | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Pemerintahan Desa" title="Profil Pemerintah Desa Pringanom" description="Kenali arah pembangunan, misi pelayanan, struktur organisasi, serta kontak resmi Pemerintah Desa Pringanom." />

        @if ($profile)
            <div class="mt-10 grid gap-8 lg:grid-cols-2">
                <article class="content-card p-6 sm:p-8">
                    <h2 class="border-l-4 border-desaYellow pl-4 text-2xl font-bold text-desaBlue">Visi</h2>
                    <div class="rich-content mt-6">{!! $profile->visi !!}</div>
                </article>
                <article class="content-card p-6 sm:p-8">
                    <h2 class="border-l-4 border-desaYellow pl-4 text-2xl font-bold text-desaBlue">Misi</h2>
                    <div class="rich-content mt-6">{!! $profile->misi !!}</div>
                </article>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-3">
                <article class="content-card overflow-hidden lg:col-span-2">
                    <div class="border-b border-slate-100 p-6"><h2 class="flex items-center gap-3 text-2xl font-bold text-blue-900"><span class="h-7 w-1.5 rounded-full bg-amber-500"></span>Media & Struktur Desa</h2></div>
                    @if (str_contains($profile->struktur_organisasi_path, '<iframe'))
                        <div class="rich-content p-4">{!! $profile->struktur_organisasi_path !!}</div>
                    @else
                        <x-smart-image :src="asset('storage/'.$profile->struktur_organisasi_path)" alt="Struktur organisasi dan Kantor Desa Pringanom" class="aspect-video w-full" img-class="h-full w-full object-contain p-4" />
                        <p class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-sm text-slate-500">Area ini siap menampilkan embed video YouTube profil Kantor Desa Pringanom dari konten RichEditor.</p>
                    @endif
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