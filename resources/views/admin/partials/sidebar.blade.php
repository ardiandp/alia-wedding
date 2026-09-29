@php
    $user = auth()->user();

    $isAdmin = $user?->isAdmin() ?? false;

    $menuGroups = [
        [
            'label' => null,
            'items' => [
                ['label' => 'Dashboard', 'icon' => 'grid', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'badge' => null],
            ],
        ],
        [
            'label' => 'CRM',
            'items' => [
                ['label' => 'Prospek', 'icon' => 'target', 'route' => 'admin.leads.index', 'pattern' => 'admin.leads.*', 'badge' => 'new'],
            ],
        ],
        [
            'label' => 'Konten',
            'items' => [
                ['label' => 'Venue', 'icon' => 'building', 'route' => 'admin.venues.index', 'pattern' => 'admin.venues.*', 'adminOnly' => true],
                ['label' => 'Paket', 'icon' => 'tag', 'route' => 'admin.packages.index', 'pattern' => 'admin.packages.*', 'adminOnly' => true],
                ['label' => 'Agenda', 'icon' => 'calendar', 'route' => 'admin.events.index', 'pattern' => 'admin.events.*', 'adminOnly' => true],
                ['label' => 'Artikel', 'icon' => 'document', 'route' => 'admin.articles.index', 'pattern' => 'admin.articles.*', 'adminOnly' => true],
                ['label' => 'Galeri', 'icon' => 'photo', 'route' => 'admin.galleries.index', 'pattern' => 'admin.galleries.*', 'adminOnly' => true],
                ['label' => 'Testimoni', 'icon' => 'star', 'route' => 'admin.testimonials.index', 'pattern' => 'admin.testimonials.*', 'adminOnly' => true],
                ['label' => 'Tim', 'icon' => 'users', 'route' => 'admin.teams.index', 'pattern' => 'admin.teams.*', 'adminOnly' => true],
                ['label' => 'Layanan', 'icon' => 'briefcase', 'route' => 'admin.services.index', 'pattern' => 'admin.services.*', 'adminOnly' => true],
            ],
        ],
        [
            'label' => 'Media',
            'items' => [
                ['label' => 'Pustaka Media', 'icon' => 'photo', 'route' => 'admin.media.index', 'pattern' => 'admin.media.*', 'adminOnly' => true],
            ],
        ],
        [
            'label' => 'Situs',
            'items' => [
                ['label' => 'Beranda', 'icon' => 'home', 'route' => 'admin.homepage.edit', 'pattern' => 'admin.homepage.*', 'adminOnly' => true],
                ['label' => 'Tentang', 'icon' => 'document', 'route' => 'admin.about.edit', 'pattern' => 'admin.about.*', 'adminOnly' => true],
            ],
        ],
        [
            'label' => 'Sistem',
            'items' => [
                ['label' => 'Pengguna', 'icon' => 'user', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'adminOnly' => true],
                ['label' => 'Pengaturan', 'icon' => 'cog', 'route' => 'admin.settings.index', 'pattern' => 'admin.settings.*', 'adminOnly' => true],
            ],
        ],
    ];
@endphp

<aside class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-gray-200 bg-white transition-transform duration-300 lg:translate-x-0 dark:border-gray-800 dark:bg-gray-900"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- Brand -->
    <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-gray-200 px-5 dark:border-gray-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white">
                <x-admin.icon name="star" class="h-5 w-5" />
            </span>
            <span class="min-w-0">
                <span class="block truncate text-sm font-bold text-gray-900 dark:text-white">Alia Wedding</span>
                <span class="block truncate text-xs text-gray-500 dark:text-gray-400">Panel Admin</span>
            </span>
        </a>

        <button type="button" @click="sidebarOpen = false"
                class="ml-auto rounded-lg p-1.5 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/[0.06] lg:hidden">
            <x-admin.icon name="x" class="h-5 w-5" />
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">
        @foreach ($menuGroups as $group)
            @php
                $visibleItems = collect($group['items'])->reject(
                    fn ($item) => ($item['adminOnly'] ?? false) && ! $isAdmin
                );
            @endphp

            @continue($visibleItems->isEmpty())

            <div>
                @if ($group['label'])
                    <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                        {{ $group['label'] }}
                    </p>
                @endif

                <ul class="space-y-1">
                    @foreach ($visibleItems as $item)
                        @php $active = request()->routeIs($item['pattern']); @endphp

                        <li>
                            <a href="{{ route($item['route']) }}"
                               @if ($active) aria-current="page" @endif
                               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $active
                                    ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-300'
                                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/[0.06] dark:hover:text-white' }}">

                                <x-admin.icon :name="$item['icon']"
                                              class="h-5 w-5 shrink-0 {{ $active ? 'text-brand-600 dark:text-brand-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" />

                                <span class="truncate">{{ $item['label'] }}</span>

                                @if (($item['badge'] ?? null) === 'new' && $newLeadsCount > 0)
                                    <span class="ml-auto rounded-full bg-red-500 px-2 py-0.5 text-xs font-semibold text-white">
                                        {{ $newLeadsCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <!-- Footer -->
    <div class="shrink-0 border-t border-gray-200 p-3 dark:border-gray-800">
        <a href="{{ route('home') }}" target="_blank" rel="noopener"
           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/[0.06] dark:hover:text-white">
            <x-admin.icon name="eye" class="h-5 w-5 shrink-0 text-gray-400" />
            <span>Lihat Situs</span>
            <x-admin.icon name="arrow-right" class="ml-auto h-4 w-4 text-gray-400" />
        </a>
    </div>
</aside>
