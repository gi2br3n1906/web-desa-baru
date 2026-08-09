<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Menu Pintas Perangkat Desa</x-slot>
        <x-slot name="description">Akses cepat ke pekerjaan administrasi yang paling sering digunakan.</x-slot>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach ($menus as $menu)
                <a href="{{ $menu['url'] }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-primary-400 hover:shadow-md dark:border-white/10 dark:bg-gray-900">
                    <div @class([
                        'flex size-12 items-center justify-center rounded-xl',
                        'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' => $menu['color'] === 'amber',
                        'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' => $menu['color'] === 'blue',
                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' => $menu['color'] === 'emerald',
                        'bg-violet-100 text-violet-700 dark:bg-violet-500/20 dark:text-violet-400' => $menu['color'] === 'violet',
                        'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400' => $menu['color'] === 'rose',
                    ])>
                        <x-filament::icon :icon="$menu['icon']" class="size-7" />
                    </div>
                    <h3 class="mt-4 font-bold text-gray-950 group-hover:text-primary-600 dark:text-white">{{ $menu['label'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $menu['description'] }}</p>
                    <span class="mt-4 inline-flex items-center text-sm font-semibold text-primary-600">Buka menu <span class="ml-1" aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>