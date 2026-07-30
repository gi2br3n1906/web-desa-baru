@extends('layouts.app')
@section('title', 'Beranda | Desa Pringanom')
@section('content')
@php
$slides = [
 ['hero-banner-1','Bentang Gunung Pringanom','Selamat Datang di Portal Informasi dan Layanan Desa Pringanom'],
 ['hero-banner-2','Hamparan sawah Desa Pringanom','Tumbuh Bersama dari Potensi Pertanian Desa'],
 ['hero-banner-3','Jalan Desa Pringanom saat matahari terbenam','Pelayanan Lebih Dekat, Informasi Lebih Terbuka'],
];
@endphp
<section class="page-container pb-8 pt-6 lg:pb-10 lg:pt-8">
 <div id="hero-carousel" class="relative h-[320px] overflow-hidden rounded-2xl bg-slate-800 shadow-xl md:h-[440px]" aria-roledescription="carousel" aria-label="Pemandangan Desa Pringanom">
  @foreach($slides as [$filename,$alt,$heading]) @php
      $image = \App\Support\BrandAssets::image($filename);
  @endphp
  <article class="absolute inset-0 transition-opacity duration-700 {{ $loop->first?'opacity-100':'pointer-events-none opacity-0' }}" data-carousel-slide aria-hidden="{{ $loop->first?'false':'true' }}">
   <x-smart-image :src="$image ? asset($image) : null" :alt="$alt" class="h-full w-full" :eager="$loop->first" :zoom="false" />
   <div class="absolute inset-0 bg-slate-950/45"></div>
   <div class="absolute inset-0 flex items-end p-6 sm:p-10 lg:p-14"><div class="max-w-3xl text-white">
    <p class="flex items-center gap-3 text-sm font-bold uppercase tracking-[.18em] text-amber-400"><span class="inline-block h-7 w-1.5 rounded-full bg-amber-500"></span>Desa Pringanom</p>
    <h1 class="mt-4 text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">{{ $heading }}</h1>
    <p class="mt-4 hidden max-w-2xl text-base leading-7 text-slate-100 sm:block">Portal resmi untuk layanan administrasi, informasi desa, kesehatan, pertanian, fasilitas publik, dan pemberdayaan masyarakat.</p>
    <a href="{{ route('services') }}" class="primary-button mt-6">Jelajahi Layanan</a>
   </div></div>
  </article>@endforeach
  <button type="button" data-carousel-prev class="absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full border border-white/30 bg-white/20 p-3 text-white backdrop-blur-md" aria-label="Slide sebelumnya">←</button>
  <button type="button" data-carousel-next class="absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full border border-white/30 bg-white/20 p-3 text-white backdrop-blur-md" aria-label="Slide berikutnya">→</button>
  <div class="absolute bottom-5 right-6 z-10 flex gap-2">@foreach($slides as $slide)<button type="button" data-carousel-dot="{{ $loop->index }}" class="h-2.5 rounded-full {{ $loop->first?'w-8 bg-amber-500':'w-2.5 bg-white/60' }}" aria-label="Buka slide {{ $loop->iteration }}"></button>@endforeach</div>
 </div>
</section>
<section class="page-container py-10"><p class="section-kicker">Akses Cepat</p><h2 class="page-heading mt-4">Layanan untuk masyarakat desa</h2>
 <div class="-mx-4 mt-8 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-4 sm:mx-0 sm:px-0 lg:grid lg:grid-cols-6 lg:overflow-visible">
 @foreach([[route('profile'),'⌂','Profil Desa'],[route('services'),'✓','Layanan'],[route('potentials'),'✦','Potensi'],[route('facilities'),'⌖','Fasilitas'],[route('posyandu'),'+','Posyandu'],[route('agriculture'),'♧','Pertanian']] as [$url,$icon,$label])
 <a href="{{ $url }}" class="content-card group min-w-[150px] snap-start p-5 text-center lg:min-w-0"><span class="mx-auto flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-blue-50 text-xl font-bold text-blue-900 transition group-hover:bg-amber-500">{{ $icon }}</span><h3 class="mt-4 font-bold text-blue-900">{{ $label }}</h3></a>@endforeach
 </div>
</section>
<section class="bg-slate-100"><div class="mx-auto grid max-w-7xl grid-cols-2 px-4 py-10 sm:px-6 md:grid-cols-4 lg:px-8">@foreach([['8','Modul Informasi'],['24/7','Akses Portal'],['1','Desa Terintegrasi'],['2026','Tahun Pelayanan']] as [$number,$label])<div class="p-5 text-center"><strong class="block text-3xl font-extrabold text-blue-900 sm:text-4xl">{{ $number }}</strong><span class="mt-2 block text-sm font-medium text-slate-600">{{ $label }}</span></div>@endforeach</div></section>
<script>document.addEventListener('DOMContentLoaded',()=>{const c=document.getElementById('hero-carousel');if(!c)return;const s=[...c.querySelectorAll('[data-carousel-slide]')],d=[...c.querySelectorAll('[data-carousel-dot]')];let a=0;const show=i=>{a=(i+s.length)%s.length;s.forEach((x,n)=>{const on=n===a;x.classList.toggle('opacity-100',on);x.classList.toggle('opacity-0',!on);x.classList.toggle('pointer-events-none',!on);x.setAttribute('aria-hidden',String(!on))});d.forEach((x,n)=>{const on=n===a;x.classList.toggle('w-8',on);x.classList.toggle('bg-amber-500',on);x.classList.toggle('w-2.5',!on);x.classList.toggle('bg-white/60',!on)})};c.querySelector('[data-carousel-prev]').onclick=()=>show(a-1);c.querySelector('[data-carousel-next]').onclick=()=>show(a+1);d.forEach((x,n)=>x.onclick=()=>show(n));setInterval(()=>show(a+1),7000)});</script>
@endsection