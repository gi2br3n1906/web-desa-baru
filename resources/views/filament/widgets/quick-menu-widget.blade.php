<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Menu Pintas Perangkat Desa</x-slot>
        <x-slot name="description">Akses cepat ke pekerjaan administrasi yang paling sering digunakan.</x-slot>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($menus as $menu)
                <a href="{{ $menu['url'] }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-primary-400 hover:shadow-md dark:border-white/10 dark:bg-gray-900">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400">
                        <x-filament::icon :icon="$menu['icon']" class="h-5 w-5 shrink-0" />
                    </div>
                    <h3 class="mt-4 font-bold text-gray-950 group-hover:text-primary-600 dark:text-white">{{ $menu['label'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $menu['description'] }}</p>
                    <span class="mt-4 inline-flex items-center text-sm font-semibold text-primary-600">Buka menu <span class="ml-1" aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>