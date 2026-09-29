@php
    $user = auth()->user();

    $roleLabels = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'staff' => 'Staff',
    ];

    $roleTones = [
        'super_admin' => 'purple',
        'admin' => 'brand',
        'staff' => 'gray',
    ];

    $role = $user?->role ?? 'staff';

    $initials = collect(explode(' ', $user?->name ?? 'A'))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
@endphp

<header x-data="{ profileOpen: false, mobileMenuOpen: false }"
        class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-gray-200 bg-white/90 px-4 backdrop-blur-sm sm:px-6 dark:border-gray-800 dark:bg-gray-900/90 lg:px-8">

    <button type="button" @click="sidebarOpen = true"
            class="rounded-xl p-2 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/[0.06] lg:hidden">
        <x-admin.icon name="menu" class="h-5 w-5" />
    </button>

    <!-- Search -->
    <div class="relative hidden max-w-md flex-1 sm:block">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
            <x-admin.icon name="search" class="h-4 w-4" />
        </span>

        <input type="search" placeholder="Cari menu atau data..."
               class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-4 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:bg-white focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white dark:placeholder:text-gray-500 dark:focus:bg-white/[0.06]" />
    </div>

    <div class="ml-auto flex items-center gap-1 sm:gap-2">
        <!-- Dark / Light toggle -->
        <button type="button" @click="toggleTheme()"
                class="rounded-xl p-2.5 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/[0.06]"
                aria-label="Ganti tema">
            <span class="hidden h-5 w-5 dark:hidden">
                <x-admin.icon name="sun" class="h-5 w-5" />
            </span>
            <span class="hidden h-5 w-5 dark:block">
                <x-admin.icon name="moon" class="h-5 w-5" />
            </span>
        </button>

        <span class="mx-1 hidden h-8 w-px bg-gray-200 dark:bg-gray-700 sm:block"></span>

        <!-- Profile -->
        <div class="relative" @click.outside="profileOpen = false">
            <button type="button" @click="profileOpen = !profileOpen"
                    class="flex items-center gap-3 rounded-xl p-1.5 pr-2 transition hover:bg-gray-100 dark:hover:bg-white/[0.06]">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-600 text-sm font-semibold text-white">
                    {{ $initials ?: 'A' }}
                </span>

                <span class="hidden min-w-0 text-left sm:block">
                    <span class="block max-w-[10rem] truncate text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $user?->name }}
                    </span>
                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                        {{ $roleLabels[$role] ?? $role }}
                    </span>
                </span>

                <x-admin.icon name="chevron-down" class="hidden h-4 w-4 text-gray-400 sm:block" />
            </button>

            <div x-show="profileOpen" x-cloak
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute right-0 mt-2 w-56 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">

                <div class="border-b border-gray-100 px-4 py-3 dark:border-gray-700">
                    <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $user?->name }}</p>
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $user?->email }}</p>
                    <div class="mt-2">
                        <x-admin.badge :tone="$roleTones[$role] ?? 'gray'">
                            {{ $roleLabels[$role] ?? $role }}
                        </x-admin.badge>
                    </div>
                </div>

                <div class="p-1.5">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/[0.06]">
                        <x-admin.icon name="user" class="h-4 w-4 text-gray-400" />
                        Profil Saya
                    </a>

                    <a href="{{ route('home') }}" target="_blank" rel="noopener"
                       class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/[0.06]">
                        <x-admin.icon name="eye" class="h-4 w-4 text-gray-400" />
                        Lihat Situs
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                            <x-admin.icon name="logout" class="h-4 w-4" />
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
