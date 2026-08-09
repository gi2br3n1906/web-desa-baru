<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#1e3a8a">
<meta name="csrf-token" content="{{ csrf_token() }}">
@if (auth()->user()?->role === 'admin')
    <meta name="pwa-umkm-sync-authorized" content="1">
@endif