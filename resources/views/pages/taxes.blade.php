@extends('layouts.app')
@section('title','Kalender Pajak UMKM | Desa Pringanom')
@section('content')
<section class="page-container"><x-page-header eyebrow="Perpajakan UMKM" title="Kalender & Panduan Pajak" description="Pantau batas pelaporan otomatis dan agenda perpajakan khusus." />
<section class="content-card mt-10 p-6"><div class="flex items-center justify-between"><h2 class="text-2xl font-bold text-blue-900">{{ $calendarMonth->translatedFormat('F Y') }}</h2><span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-bold text-amber-800">Batas: {{ $taxDeadline->translatedFormat('d F') }}</span></div>
@php
    $start = $calendarMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
@endphp
<div class="mt-6 grid grid-cols-7 gap-1 text-center text-xs font-bold text-slate-500">@foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $d)<div class="p-2">{{ $d }}</div>@endforeach</div><div class="grid grid-cols-7 gap-1">@for($i=0;$i<42;$i++)@php
    $day = $start->copy()->addDays($i);
    $special = $day->isSameDay($taxDeadline);
    $custom = $taxSchedules->first(fn ($schedule) => $schedule->tanggal->isSameDay($day));
@endphp<div class="min-h-20 rounded-lg border p-2 {{ $day->month===$calendarMonth->month?'bg-white':'bg-slate-50 text-slate-400' }} {{ $special?'border-amber-500 bg-amber-50':'' }}"><span class="font-bold">{{ $day->day }}</span>@if($special)<p class="mt-1 text-[10px] font-bold text-amber-800">Batas pajak</p>@endif @if($custom)<p class="mt-1 text-[10px] text-blue-900">{{ $custom->judul_kegiatan }}</p>@endif</div>@endfor</div><p class="mt-5 rounded-xl bg-amber-50 p-4 font-semibold text-amber-900">{{ $taxDeadlineNote }}</p></section>
<section class="mt-12 grid gap-6 lg:grid-cols-2">@foreach($guides as $guide)<article class="content-card p-6"><h2 class="text-xl font-bold text-blue-900">{{ $guide->kategori_umkm }}</h2><span class="mt-3 inline-block rounded-full bg-blue-50 px-3 py-1 font-bold text-blue-900">{{ $guide->tarif_informasi }}</span><div class="rich-content mt-5">{!! $guide->alur_pajak !!}</div></article>@endforeach</section>
<section class="mt-14"><h2 class="section-kicker">FAQ Pajak</h2><div class="mt-6 space-y-3">@forelse($faqs as $faq)<details class="content-card p-5"><summary class="cursor-pointer font-bold text-blue-900">{{ $faq->pertanyaan }}</summary><div class="rich-content mt-4">{!! $faq->jawaban !!}</div></details>@empty<p class="empty-state">FAQ pajak belum tersedia.</p>@endforelse</div></section></section>@endsection