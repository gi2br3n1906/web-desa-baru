@props(['compact' => false])

<div {{ $attributes->merge(['class' => 'items-center gap-1.5 text-xs font-bold']) }} data-pwa-status>
    <span class="inline-flex shrink-0 items-center gap-1 whitespace-nowrap text-green-700" data-pwa-connection title="Online">
        <span data-pwa-dot aria-hidden="true">🟢</span>
        <span class="{{ $compact ? 'hidden xl:inline-flex' : 'inline-flex' }}" data-pwa-text>Online</span>
    </span>
    <span class="shrink-0 items-center gap-1 whitespace-nowrap rounded-full bg-amber-100 px-2 py-1 text-amber-800 ring-1 ring-amber-200" data-pwa-queue hidden>
        <span aria-hidden="true">📥</span>
        <span data-pwa-count>0</span>
        <span class="{{ $compact ? 'hidden xl:inline' : 'inline' }}">Antrean Sync</span>
    </span>
</div>