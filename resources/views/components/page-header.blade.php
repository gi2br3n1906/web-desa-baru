@props(['eyebrow', 'title', 'description'])

<header class="max-w-3xl">
    <p class="section-kicker">{{ $eyebrow }}</p>
    <h1 class="page-heading mt-4">{{ $title }}</h1>
    <p class="mt-4 text-base leading-7 text-slate-600 sm:text-lg">{{ $description }}</p>
</header>