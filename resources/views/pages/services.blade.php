@extends('layouts.app')

@section('title', 'Panduan Administrasi & Produk Hukum | Desa Pringanom')

@section('content')
    <section class="page-container">
        <x-page-header eyebrow="Administrasi & Produk Hukum" title="Panduan Administrasi & Produk Hukum" description="Persiapkan dokumen layanan dan akses produk hukum Desa Pringanom sebelum datang ke kantor desa." />

        <section id="produk-hukum" class="mt-10 scroll-mt-24" aria-labelledby="produk-hukum-heading">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="section-kicker">Dokumen Pemerintahan Desa</p>
                    <h2 id="produk-hukum-heading" class="mt-4 text-3xl font-black text-blue-900">Produk Hukum Desa</h2>
                    <p class="mt-3 max-w-3xl leading-7 text-slate-600">Kumpulan Peraturan Desa yang tersedia untuk dibaca dan diunduh oleh masyarakat Desa Pringanom.</p>
                </div>
                <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-bold text-blue-900">{{ $legalProducts->count() }} dokumen tersedia</span>
            </div>

            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full min-w-[58rem] text-left">
                        <thead class="bg-blue-950 text-sm text-white">
                            <tr>
                                <th class="px-6 py-4 font-bold">Judul Peraturan</th>
                                <th class="px-6 py-4 font-bold">Nomor &amp; Tahun</th>
                                <th class="px-6 py-4 font-bold">Kategori</th>
                                <th class="px-6 py-4 font-bold">Tentang</th>
                                <th class="px-6 py-4 text-right font-bold">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($legalProducts as $product)
                                <tr class="align-top hover:bg-slate-50">
                                    <td class="px-6 py-5 font-black text-blue-900">{{ $product->judul_peraturan }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-600">{{ $product->nomor_tahun }}</td>
                                    <td class="px-6 py-5"><span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">{{ $product->kategori }}</span></td>
                                    <td class="max-w-sm px-6 py-5 text-sm leading-6 text-slate-600">{{ $product->tentang }}</td>
                                    <td class="px-6 py-5 text-right"><a href="{{ asset($product->file_path) }}" download class="inline-flex items-center rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-amber-600">Unduh Dokumen (PDF) <span class="ml-2" aria-hidden="true">↓</span></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Produk hukum desa belum tersedia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="space-y-4 p-4 md:hidden">
                    @forelse ($legalProducts as $product)
                        <article class="rounded-xl border border-slate-200 p-5">
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">{{ $product->kategori }}</span>
                            <h3 class="mt-4 text-lg font-black text-blue-900">{{ $product->judul_peraturan }}</h3>
                            <dl class="mt-4 space-y-3 text-sm"><div><dt class="font-bold text-slate-500">Nomor &amp; Tahun</dt><dd class="mt-1 text-slate-700">{{ $product->nomor_tahun }}</dd></div><div><dt class="font-bold text-slate-500">Tentang</dt><dd class="mt-1 leading-6 text-slate-700">{{ $product->tentang }}</dd></div></dl>
                            <a href="{{ asset($product->file_path) }}" download class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-amber-500 px-4 py-3 font-bold text-white transition hover:bg-amber-600">Unduh Dokumen (PDF) <span class="ml-2" aria-hidden="true">↓</span></a>
                        </article>
                    @empty
                        <div class="empty-state">Produk hukum desa belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="content-card mt-10 p-6 sm:p-8" id="pengajuan-online">
            <h2 class="text-2xl font-bold text-blue-900">Pengajuan Layanan Online</h2>
            <p class="mt-2 text-slate-600">Isi data dengan benar. Berkas maksimal 5 MB dalam format PDF/JPG/PNG.</p>
            @if(session('success'))<div class="mt-5 rounded-xl bg-green-50 p-4 font-semibold text-green-800">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="mt-5 rounded-xl bg-red-50 p-4 text-red-800"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ route('services.request.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-5 md:grid-cols-2">@csrf
                <label class="md:col-span-2"><span class="font-semibold text-slate-700">Pilih Layanan</span><select name="admin_service_id" required class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-800 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500"><option value="">Pilih layanan</option>@foreach($services as $service)<option value="{{ $service->id }}" @selected(old('admin_service_id')==$service->id)>{{ $service->nama_layanan }}</option>@endforeach</select></label>
                <label><span class="font-semibold text-slate-700">Nama Lengkap</span><input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama sesuai KTP" required class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500"></label>
                <label><span class="font-semibold text-slate-700">NIK (16 digit)</span><input type="text" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" required inputmode="numeric" pattern="[0-9]{16}" minlength="16" maxlength="16" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500"></label>
                <label><span class="font-semibold text-slate-700">No. WhatsApp</span><input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}" placeholder="Contoh: 081234567890" required inputmode="tel" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500"></label>
                <label><span class="font-semibold text-slate-700">Berkas Syarat</span><input name="file_lampiran" type="file" accept=".pdf,.jpg,.jpeg,.png" class="mt-1.5 w-full cursor-pointer rounded-xl border border-slate-300 bg-white p-1 text-sm file:mr-4 file:rounded-xl file:border-0 file:bg-amber-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-amber-700 hover:file:bg-amber-100"></label>
                <label class="md:col-span-2"><span class="font-semibold text-slate-700">Alamat</span><textarea name="alamat" required rows="3" placeholder="Alamat lengkap RT/RW dan dukuh" class="mt-1.5 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500">{{ old('alamat') }}</textarea></label>
                <button class="primary-button md:col-span-2 md:justify-self-start">Kirim Pengajuan</button>
            </form>
        </section>

        <div class="mt-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="section-kicker">Panduan Administrasi Desa</p>
                <h2 class="mt-4 text-3xl font-black text-blue-900">Daftar Layanan Administrasi</h2>
                <p class="mt-3 max-w-3xl leading-7 text-slate-600">Periksa persyaratan terbaru untuk setiap layanan sebelum mengirim pengajuan atau datang ke Kantor Desa Pringanom.</p>
            </div>
            <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-bold text-blue-900">{{ $services->count() }} layanan tersedia</span>
        </div>

        <div class="mt-8 space-y-8">
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