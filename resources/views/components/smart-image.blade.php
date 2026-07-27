@props([
    'src' => null,
    'alt',
    'class' => '',
    'imgClass' => 'h-full w-full object-cover',
    'eager' => false,
    'zoom' => true,
])

<div {{ $attributes->class(['image-shell', $class]) }}>
    @if ($src)
        <div class="absolute inset-0 animate-pulse bg-slate-200" data-image-skeleton aria-hidden="true"></div>
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            class="{{ $imgClass }} opacity-0 {{ $zoom ? 'hover:scale-105' : '' }}"
            loading="{{ $eager ? 'eager' : 'lazy' }}"
            decoding="async"
            onload="this.classList.remove('opacity-0'); this.previousElementSibling?.remove()"
        >
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-slate-200 via-slate-100 to-blue-50" aria-hidden="true"></div>
        <div class="relative flex h-full w-full items-center justify-center p-6 text-center text-sm font-semibold text-slate-500">
            Gambar akan tampil setelah aset tersedia
        </div>
    @endif
</div>