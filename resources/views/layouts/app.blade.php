<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
@php
    $sragenLogoPath = \App\Support\BrandAssets::sragenLogo();
    $kknLogoPath = \App\Support\BrandAssets::kknUndipLogo();
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (auth()->user()?->role === 'admin')
        <meta name="pwa-umkm-sync-authorized" content="1">
    @endif
    <meta name="description" content="Portal resmi informasi dan pelayanan Pemerintah Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen.">
    <meta name="theme-color" content="#1e3a8a">
    <link rel="manifest" href="/manifest.json">

    <title>@yield('title', 'Portal Desa Pringanom')</title>

    @if ($sragenLogoPath)
        <link rel="icon" href="{{ asset($sragenLogoPath) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    @php
        $governmentActive = request()->routeIs('profile', 'services', 'potentials');
        $facilityActive = request()->routeIs('facilities', 'posyandu');
        $empowermentActive = request()->routeIs('agriculture', 'accounting', 'umkm', 'taxes');
        $desktopLink = 'whitespace-nowrap rounded-full px-2 py-1.5 text-xs font-semibold text-blue-900 transition hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-amber-500 xl:px-3 xl:text-sm';
        $dropdownLink = 'block rounded-lg px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-desaBlue focus:bg-blue-50 focus:text-desaBlue focus:outline-none';
    @endphp

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/85 text-blue-900 shadow-sm backdrop-blur-md">
        <nav class="mx-auto max-w-7xl overflow-hidden px-4 hover:overflow-visible focus-within:overflow-visible sm:px-6 lg:px-8" aria-label="Navigasi utama">
            <div class="flex h-16 flex-nowrap items-center justify-between gap-2 overflow-hidden hover:overflow-visible focus-within:overflow-visible">
                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-desaYellow xl:gap-3">
                    @if ($sragenLogoPath)
                        <img src="{{ asset($sragenLogoPath) }}" alt="Logo resmi Kabupaten Sragen" class="h-9 w-auto shrink-0 object-contain mix-blend-multiply xl:h-11" width="44" height="44">
                    @else
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-desaYellow text-lg font-black text-desaBlue" aria-hidden="true">P</span>
                    @endif
                    <span>
                        <span class="block whitespace-nowrap text-xs font-bold leading-tight xl:text-base">Desa Pringanom</span>
                        <span class="hidden text-xs text-slate-500 2xl:block">Kecamatan Masaran, Kabupaten Sragen</span>
                    </span>
                </a>

                <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center rounded-full p-2 text-blue-900 transition hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-amber-500 lg:hidden" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Buka menu utama</span>
                    <svg id="menu-open-icon" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="menu-close-icon" class="hidden size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="hidden min-w-0 flex-1 flex-nowrap items-center justify-end gap-1 overflow-hidden hover:overflow-visible focus-within:overflow-visible lg:flex xl:gap-2">
                    <div class="flex shrink-0 items-center gap-1 xl:gap-2">
                        <a href="{{ route('home') }}" class="{{ $desktopLink }} {{ request()->routeIs('home') ? 'bg-blue-50' : '' }}">Beranda</a>
                        <a href="{{ route('news.index') }}" class="{{ $desktopLink }} {{ request()->routeIs('news.*') ? 'bg-blue-50' : '' }}">Kabar Desa</a>

                        <div class="group relative shrink-0">
                            <button type="button" class="{{ $desktopLink }} inline-flex items-center gap-1 {{ $governmentActive ? 'bg-blue-50' : '' }}" aria-haspopup="true">
                                Pemerintahan & Layanan
                                <svg class="hidden size-4 transition group-hover:rotate-180 group-focus-within:rotate-180 xl:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                            </button>
                            <div class="invisible absolute right-0 top-full w-64 translate-y-2 rounded-xl bg-white p-2 opacity-0 shadow-xl ring-1 ring-slate-200 transition duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                                <a href="{{ route('profile') }}" class="{{ $dropdownLink }}">Profil Pemerintah Desa</a>
                                <a href="{{ route('services') }}" class="{{ $dropdownLink }}">Panduan Administrasi & Hukum</a>
                                <a href="{{ route('potentials') }}" class="{{ $dropdownLink }}">Potensi Desa Bilingual</a>
                            </div>
                        </div>

                        <div class="group relative shrink-0">
                            <button type="button" class="{{ $desktopLink }} inline-flex items-center gap-1 {{ $facilityActive ? 'bg-blue-50' : '' }}" aria-haspopup="true">
                                Fasilitas & Kesehatan
                                <svg class="hidden size-4 transition group-hover:rotate-180 group-focus-within:rotate-180 xl:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                            </button>
                            <div class="invisible absolute right-0 top-full w-60 translate-y-2 rounded-xl bg-white p-2 opacity-0 shadow-xl ring-1 ring-slate-200 transition duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                                <a href="{{ route('facilities') }}" class="{{ $dropdownLink }}">Peta Fasilitas Desa</a>
                                <a href="{{ route('posyandu') }}" class="{{ $dropdownLink }}">Informasi Posyandu</a>
                            </div>
                        </div>

                        <div class="group relative shrink-0">
                            <button type="button" class="{{ $desktopLink }} inline-flex items-center gap-1 {{ $empowermentActive ? 'bg-blue-50' : '' }}" aria-haspopup="true">
                                Pemberdayaan & UMKM
                                <svg class="hidden size-4 transition group-hover:rotate-180 group-focus-within:rotate-180 xl:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                            </button>
                            <div class="invisible absolute right-0 top-full w-60 translate-y-2 rounded-xl bg-white p-2 opacity-0 shadow-xl ring-1 ring-slate-200 transition duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                                <a href="{{ route('agriculture') }}" class="{{ $dropdownLink }}">Panduan Alat Tani</a>
                                <a href="{{ route('accounting') }}" class="{{ $dropdownLink }}">Pembukuan UMKM</a>
                                <a href="{{ route('umkm') }}" class="{{ $dropdownLink }}">Direktori UMKM</a>
                                <a href="{{ route('taxes') }}" class="{{ $dropdownLink }}">Panduan Pajak UMKM</a>
                            </div>
                        </div>
                    </div>
                    <x-pwa-status compact class="hidden shrink-0 lg:flex" />
                    @auth
                        <div class="group relative ml-1 shrink-0 xl:ml-2">
                            <button type="button" class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full border border-blue-900 px-2 py-1.5 text-xs font-bold text-blue-900 transition hover:bg-blue-50 xl:px-3 xl:text-sm" aria-haspopup="true">
                                <span class="max-w-[140px] truncate xl:max-w-none">{{ auth()->user()->name }}</span>
                                <span aria-hidden="true">⌄</span>
                            </button>
                            <div class="invisible absolute right-0 top-full w-48 translate-y-2 rounded-xl bg-white p-2 opacity-0 shadow-xl ring-1 ring-slate-200 transition duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ url('/admin') }}" class="{{ $dropdownLink }}"><span class="mr-2 text-amber-600" aria-hidden="true">▣</span>Panel Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full rounded-lg px-4 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-red-50 hover:text-red-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="ml-1 shrink-0 whitespace-nowrap rounded-full border border-blue-900 px-2.5 py-1.5 text-xs font-bold text-blue-900 transition hover:bg-blue-900 hover:text-white xl:ml-2 xl:px-4 xl:text-sm">Masuk</a>
                    @endauth
                </div>
            </div>

            <div id="mobile-menu" class="hidden border-t border-slate-200 pb-4 lg:hidden">
                <div class="space-y-1 pt-3">
                    <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 font-semibold transition hover:bg-blue-50">Beranda</a>
                    <a href="{{ route('news.index') }}" class="block rounded-lg px-3 py-2 font-semibold transition hover:bg-blue-50">Kabar Desa</a>
                    <details class="group rounded-lg open:bg-blue-50" {{ $governmentActive ? 'open' : '' }}>
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2 font-semibold hover:bg-blue-50">
                            Pemerintahan & Layanan
                            <span class="transition group-open:rotate-180">⌄</span>
                        </summary>
                        <div class="space-y-1 px-3 pb-2 pl-6 text-sm text-slate-600">
                            <a href="{{ route('profile') }}" class="block py-2 hover:text-blue-900">Profil Pemerintah Desa</a>
                            <a href="{{ route('services') }}" class="block py-2 hover:text-blue-900">Panduan Administrasi & Hukum</a>
                            <a href="{{ route('potentials') }}" class="block py-2 hover:text-blue-900">Potensi Desa Bilingual</a>
                        </div>
                    </details>
                    <details class="group rounded-lg open:bg-blue-50" {{ $facilityActive ? 'open' : '' }}>
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2 font-semibold hover:bg-blue-50">
                            Fasilitas & Kesehatan
                            <span class="transition group-open:rotate-180">⌄</span>
                        </summary>
                        <div class="space-y-1 px-3 pb-2 pl-6 text-sm text-slate-600">
                            <a href="{{ route('facilities') }}" class="block py-2 hover:text-blue-900">Peta Fasilitas Desa</a>
                            <a href="{{ route('posyandu') }}" class="block py-2 hover:text-blue-900">Informasi Posyandu</a>
                        </div>
                    </details>
                    <details class="group rounded-lg open:bg-blue-50" {{ $empowermentActive ? 'open' : '' }}>
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2 font-semibold hover:bg-blue-50">
                            Pemberdayaan & UMKM
                            <span class="transition group-open:rotate-180">⌄</span>
                        </summary>
                        <div class="space-y-1 px-3 pb-2 pl-6 text-sm text-slate-600">
                            <a href="{{ route('agriculture') }}" class="block py-2 hover:text-blue-900">Panduan Alat Tani</a>
                            <a href="{{ route('accounting') }}" class="block py-2 hover:text-blue-900">Pembukuan UMKM</a>
                            <a href="{{ route('umkm') }}" class="block py-2 hover:text-blue-900">Direktori UMKM</a>
                            <a href="{{ route('taxes') }}" class="block py-2 hover:text-blue-900">Panduan Pajak UMKM</a>
                        </div>
                    </details>
                    <x-pwa-status class="mt-3 flex flex-wrap rounded-xl bg-slate-50 p-3" />
                    @auth
                        <details class="group mt-2 rounded-lg border border-blue-900 open:bg-blue-50">
                            <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-4 py-2 text-sm font-bold text-blue-900">
                                <span class="truncate">{{ auth()->user()->name }}</span>
                                <span class="transition group-open:rotate-180" aria-hidden="true">⌄</span>
                            </summary>
                            <div class="space-y-1 border-t border-blue-100 p-2">
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ url('/admin') }}" class="block rounded-lg px-3 py-2 text-sm font-bold text-blue-900 hover:bg-amber-100"><span class="mr-2 text-amber-600" aria-hidden="true">▣</span>Panel Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-bold text-red-700 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </details>
                    @else
                        <a href="{{ route('login') }}" class="mt-2 block rounded-full border border-blue-900 px-4 py-2 text-center text-sm font-bold">Masuk</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="min-h-[calc(100vh-16rem)]">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div>
                <h2 class="text-lg font-bold text-white">Desa Pringanom</h2>
                <p class="mt-2 max-w-xl text-sm leading-6">Portal Resmi Pemerintahan Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen.</p>
            </div>
            <div><h2 class="font-bold text-white">Tautan Cepat</h2><div class="mt-4 space-y-2 text-sm"><a class="block hover:text-amber-400" href="{{ route('profile') }}">Profil Desa</a><a class="block hover:text-amber-400" href="{{ route('services') }}">Layanan Desa</a><a class="block hover:text-amber-400" href="{{ route('facilities') }}">Fasilitas Publik</a></div></div>
            <div><h2 class="font-bold text-white">Pemberdayaan</h2><div class="mt-4 space-y-2 text-sm"><a class="block hover:text-amber-400" href="{{ route('agriculture') }}">Alat Tani</a><a class="block hover:text-amber-400" href="{{ route('accounting') }}">Pembukuan</a><a class="block hover:text-amber-400" href="{{ route('taxes') }}">Pajak UMKM</a></div></div>
            <div>
                <h2 class="font-bold text-white">Kolaborasi</h2>
                <div class="mt-4 flex items-center gap-3">
                    @if ($kknLogoPath)<img src="{{ asset($kknLogoPath) }}" alt="Logo Tim KKN Universitas Diponegoro" class="h-10 w-auto rounded bg-white object-contain p-1" loading="lazy">@endif
                    <p class="text-sm">Dikembangkan oleh Tim KKN Undip 2026</p>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800"><div class="mx-auto max-w-7xl px-4 py-5 text-sm sm:px-6 lg:px-8">&copy; {{ now()->year }} Pemerintah Desa Pringanom. Seluruh hak dilindungi.</div>
        </div>
    </footer>

    <script>
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');

        menuButton?.addEventListener('click', () => {
            const isExpanded = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', String(!isExpanded));
            mobileMenu?.classList.toggle('hidden');
            openIcon?.classList.toggle('hidden');
            closeIcon?.classList.toggle('hidden');
        });
    </script>
    <script src="{{ asset('js/offline-db.js') }}"></script>
    <script src="{{ asset('js/offline-sync.js') }}"></script>
    <script>
        window.addEventListener('load', () => {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js', { scope: '/' })
                    .then((registration) => registration.update())
                    .catch((error) => {
                        console.error('Registrasi Service Worker publik gagal.', error);
                    });
            }
        });
    </script>
</body>
</html>