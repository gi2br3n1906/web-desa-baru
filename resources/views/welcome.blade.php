@extends('layouts.app')
@section('title', 'Beranda | Desa Pringanom')
@section('content')
@php
$slides = $heroBanners->map(static fn ($banner): array => [
    'image' => asset('storage/'.$banner->image_path),
    'alt' => $banner->title ?: 'Pemandangan Desa Pringanom',
    'title' => $banner->title,
    'subtitle' => $banner->subtitle,
    'button_text' => $banner->button_text,
    'button_url' => $banner->button_url,
])->all();

if ($slides === []) {
    $slides = collect([
        ['hero-banner-1', 'Bentang Gunung Pringanom', 'Selamat Datang di Portal Informasi dan Layanan Desa Pringanom'],
        ['hero-banner-2', 'Hamparan sawah Desa Pringanom', 'Tumbuh Bersama dari Potensi Pertanian Desa'],
        ['hero-banner-3', 'Jalan Desa Pringanom saat matahari terbenam', 'Pelayanan Lebih Dekat, Informasi Lebih Terbuka'],
    ])->map(static fn (array $slide): array => [
        'image' => ($image = \App\Support\BrandAssets::image($slide[0])) ? asset($image) : null,
        'alt' => $slide[1],
        'title' => $slide[2],
        'subtitle' => 'Portal resmi untuk layanan administrasi, informasi desa, kesehatan, pertanian, fasilitas publik, dan pemberdayaan masyarakat.',
        'button_text' => 'Jelajahi Layanan',
        'button_url' => route('services'),
    ])->all();
}
@endphp
<section class="page-container pb-8 pt-6 lg:pb-10 lg:pt-8">
 <div id="hero-carousel" class="relative h-[320px] overflow-hidden rounded-2xl bg-slate-800 shadow-xl md:h-[440px]" aria-roledescription="carousel" aria-label="Pemandangan Desa Pringanom">
  @foreach($slides as $slide)
  <article class="absolute inset-0 transition-opacity duration-700 {{ $loop->first?'opacity-100':'pointer-events-none opacity-0' }}" data-carousel-slide aria-hidden="{{ $loop->first?'false':'true' }}">
   <x-smart-image :src="$slide['image']" :alt="$slide['alt']" class="h-full w-full" :eager="$loop->first" :zoom="false" />
   <div class="absolute inset-0 bg-slate-950/45"></div>
   <div class="absolute inset-0 flex items-end p-6 sm:p-10 lg:p-14"><div class="max-w-3xl text-white">
    <p class="flex items-center gap-3 text-sm font-bold uppercase tracking-[.18em] text-amber-400"><span class="inline-block h-7 w-1.5 rounded-full bg-amber-500"></span>Desa Pringanom</p>
    @if($slide['title'])<h1 class="mt-4 text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">{{ $slide['title'] }}</h1>@endif
    @if($slide['subtitle'])<p class="mt-4 hidden max-w-2xl text-base leading-7 text-slate-100 sm:block">{{ $slide['subtitle'] }}</p>@endif
    @if($slide['button_text'] && $slide['button_url'])<a href="{{ $slide['button_url'] }}" class="primary-button mt-6">{{ $slide['button_text'] }}</a>@endif
   </div></div>
  </article>
  @endforeach
  @if(count($slides) > 1)
  <button type="button" data-carousel-prev class="absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full border border-white/30 bg-white/20 p-3 text-white backdrop-blur-md" aria-label="Slide sebelumnya">←</button>
  <button type="button" data-carousel-next class="absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full border border-white/30 bg-white/20 p-3 text-white backdrop-blur-md" aria-label="Slide berikutnya">→</button>
  <div class="absolute bottom-5 right-6 z-10 flex gap-2">@foreach($slides as $slide)<button type="button" data-carousel-dot="{{ $loop->index }}" class="h-2.5 rounded-full {{ $loop->first?'w-8 bg-amber-500':'w-2.5 bg-white/60' }}" aria-label="Buka slide {{ $loop->iteration }}"></button>@endforeach</div>
  @endif
 </div>
</section>
<section class="page-container py-10"><p class="section-kicker">Akses Cepat</p><h2 class="page-heading mt-4">Layanan untuk masyarakat desa</h2>
 <div class="-mx-4 mt-8 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-4 sm:mx-0 sm:px-0 lg:grid lg:grid-cols-6 lg:overflow-visible">
 @foreach([[route('profile'),'⌂','Profil Desa'],[route('services'),'✓','Layanan'],[route('potentials'),'✦','Potensi'],[route('facilities'),'⌖','Fasilitas'],[route('posyandu'),'+','Posyandu'],[route('agriculture'),'♧','Pertanian']] as [$url,$icon,$label])
 <a href="{{ $url }}" class="content-card group min-w-[150px] snap-start p-5 text-center lg:min-w-0"><span class="mx-auto flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-blue-50 text-xl font-bold text-blue-900 transition group-hover:bg-amber-500">{{ $icon }}</span><h3 class="mt-4 font-bold text-blue-900">{{ $label }}</h3></a>@endforeach
 </div>
</section>
<section class="page-container py-10" aria-labelledby="latest-news-heading">
 <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
  <div><p class="section-kicker">Informasi Terkini</p><h2 id="latest-news-heading" class="page-heading mt-4">Kabar Desa Terbaru</h2><p class="mt-3 max-w-2xl leading-7 text-slate-600">Berita, kegiatan, dan pengumuman terbaru dari Desa Pringanom.</p></div>
  <a href="{{ route('news.index') }}" class="inline-flex items-center font-bold text-blue-900 hover:text-amber-700">Lihat Semua Kabar Desa <span class="ml-2" aria-hidden="true">→</span></a>
 </div>
 <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
  @forelse($latestArticles as $article)
   <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-amber-400 hover:shadow-lg">
    <x-smart-image :src="$article->thumbnail_path ? asset('storage/'.$article->thumbnail_path) : null" :alt="$article->title" class="aspect-[16/9]" />
    <div class="p-5"><span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-black text-amber-800">{{ $article->category }}</span><h3 class="mt-4 text-xl font-black leading-7 text-blue-900"><a href="{{ route('news.show', $article->slug) }}" class="hover:text-amber-700">{{ $article->title }}</a></h3><p class="mt-3 text-xs font-semibold text-slate-500">{{ $article->published_at->translatedFormat('d F Y') }}</p><p class="mt-3 line-clamp-3 leading-6 text-slate-600">{{ $article->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 150) }}</p><a href="{{ route('news.show', $article->slug) }}" class="mt-5 inline-flex items-center font-bold text-blue-900 hover:text-amber-700">Baca Selengkapnya <span class="ml-2" aria-hidden="true">→</span></a></div>
   </article>
  @empty
   <div class="empty-state md:col-span-2 lg:col-span-3">Belum ada berita terbaru yang diterbitkan.</div>
  @endforelse
 </div>
</section>
<section class="bg-slate-100"><div class="mx-auto grid max-w-7xl grid-cols-2 px-4 py-10 sm:px-6 md:grid-cols-4 lg:px-8">@foreach([['8','Modul Informasi'],['24/7','Akses Portal'],['1','Desa Terintegrasi'],['2026','Tahun Pelayanan']] as [$number,$label])<div class="p-5 text-center"><strong class="block text-3xl font-extrabold text-blue-900 sm:text-4xl">{{ $number }}</strong><span class="mt-2 block text-sm font-medium text-slate-600">{{ $label }}</span></div>@endforeach</div></section>
<script>document.addEventListener('DOMContentLoaded',()=>{const c=document.getElementById('hero-carousel');if(!c)return;const s=[...c.querySelectorAll('[data-carousel-slide]')],d=[...c.querySelectorAll('[data-carousel-dot]')];if(s.length<2)return;let a=0;const show=i=>{a=(i+s.length)%s.length;s.forEach((x,n)=>{const on=n===a;x.classList.toggle('opacity-100',on);x.classList.toggle('opacity-0',!on);x.classList.toggle('pointer-events-none',!on);x.setAttribute('aria-hidden',String(!on))});d.forEach((x,n)=>{const on=n===a;x.classList.toggle('w-8',on);x.classList.toggle('bg-amber-500',on);x.classList.toggle('w-2.5',!on);x.classList.toggle('bg-white/60',!on)})};c.querySelector('[data-carousel-prev]')?.addEventListener('click',()=>show(a-1));c.querySelector('[data-carousel-next]')?.addEventListener('click',()=>show(a+1));d.forEach((x,n)=>x.addEventListener('click',()=>show(n)));setInterval(()=>show(a+1),7000)});</script>
@endsection