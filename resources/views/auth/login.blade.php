@extends('layouts.app')

@section('title', 'Masuk | Desa Pringanom')

@section('content')
    <section class="page-container py-12 sm:py-16">
        <div class="mx-auto max-w-md">
            <div class="content-card p-6 sm:p-8">
                <p class="section-kicker">Akses Terpadu</p>
                <h1 class="page-heading mt-3">Masuk ke Portal Desa</h1>
                <p class="mt-3 text-sm leading-6 text-slate-600">Gunakan akun yang diberikan Pemerintah Desa Pringanom untuk mengakses layanan dan pembukuan UMKM.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700">Kata sandi</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700">
                    </div>
                    <label class="flex items-center gap-3 text-sm text-slate-600">
                        <input name="remember" type="checkbox" value="1" class="rounded border-slate-300 text-blue-800 focus:ring-blue-700">
                        Ingat saya di perangkat ini
                    </label>
                    <button type="submit" class="primary-button w-full justify-center">Masuk</button>
                </form>
            </div>
        </div>
    </section>
@endsection