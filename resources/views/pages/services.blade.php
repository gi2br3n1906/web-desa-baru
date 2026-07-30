@extends('layouts.app')

@section('title', 'Layanan Administrasi | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Administrasi & Hukum" title="Panduan Layanan Desa" description="Persiapkan dokumen dan pahami alur pengurusan sebelum datang ke kantor desa." />

        <section class="content-card mt-10 p-6 sm:p-8" id="pengajuan-online">
            <h2 class="text-2xl font-bold text-blue-900">Pengajuan Layanan Online</h2>
            <p class="mt-2 text-slate-600">Isi data dengan benar. Berkas maksimal 5 MB dalam format PDF/JPG/PNG.</p>
            @if(session('success'))<div class="mt-5 rounded-xl bg-green-50 p-4 font-semibold text-green-800">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="mt-5 rounded-xl bg-red-50 p-4 text-red-800"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ route('services.request.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-5 md:grid-cols-2">@csrf
                <label class="md:col-span-2"><span class="font-semibold text-slate-700">Pilih Layanan</span><select name="admin_service_id" required class="mt-2 w-full rounded-xl border-slate-300"><option value="">Pilih layanan</option>@foreach($services as $service)<option value="{{ $service->id }}" @selected(old('admin_service_id')==$service->id)>{{ $service->nama_layanan }}</option>@endforeach</select></label>
                <label><span class="font-semibold text-slate-700">Nama Lengkap</span><input name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="mt-2 w-full rounded-xl border-slate-300"></label>
                <label><span class="font-semibold text-slate-700">NIK (16 digit)</span><input name="nik" value="{{ old('nik') }}" required inputmode="numeric" pattern="[0-9]{16}" minlength="16" maxlength="16" class="mt-2 w-full rounded-xl border-slate-300"></label>
                <label><span class="font-semibold text-slate-700">No. WhatsApp</span><input name="no_whatsapp" value="{{ old('no_whatsapp') }}" required type="tel" class="mt-2 w-full rounded-xl border-slate-300"></label>
                <label><span class="font-semibold text-slate-700">Berkas Syarat</span><input name="file_lampiran" type="file" accept=".pdf,.jpg,.jpeg,.png" class="mt-2 block w-full text-sm"></label>
                <label class="md:col-span-2"><span class="font-semibold text-slate-700">Alamat</span><textarea name="alamat" required rows="3" class="mt-2 w-full rounded-xl border-slate-300">{{ old('alamat') }}</textarea></label>
                <button class="primary-button md:col-span-2 md:justify-self-start">Kirim Pengajuan</button>
            </form>
        </section>

        <div class="mt-10 space-y-8">
            @forelse ($services as $service)
                <article class="content-card overflow-hidden">
                    <header class="border-b border-slate-100 bg-blue-50 px-6 py-5 sm:px-8"><h2 class="text-xl font-bold text-blue-900 sm:text-2xl">{{ $service->nama_layanan }}</h2></header>
                    <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-2">
                        <section>
                            <h3 class="border-l-4 border-desaYellow pl-3 text-lg font-bold text-desaBlue">Persyaratan</h3>
                            <div class="rich-content mt-5">{!! $service->persyaratan !!}</div>
                        </section>
                        <section>
                            <h3 class="border-l-4 border-desaYellow pl-3 text-lg font-bold text-desaBlue">Alur Pengurusan</h3>
                            <div class="rich-content mt-5">{!! $service->alur_pengurusan !!}</div>
                        </section>
                    </div>
                </article>
            @empty
                <div class="empty-state">Panduan layanan belum tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection