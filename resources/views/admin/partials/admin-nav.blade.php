@php
$adminNav = [
    ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard'],
    ['label' => 'Prospek', 'route' => 'admin.leads.index', 'pattern' => 'admin.leads.*'],
    ['label' => 'Media', 'route' => 'admin.media.index', 'pattern' => 'admin.media.*'],
    ['label' => 'Venue', 'route' => 'admin.venues.index', 'pattern' => 'admin.venues.*'],
    ['label' => 'Paket', 'route' => 'admin.packages.index', 'pattern' => 'admin.packages.*'],
    ['label' => 'Agenda', 'route' => 'admin.events.index', 'pattern' => 'admin.events.*'],
    ['label' => 'Artikel', 'route' => 'admin.articles.index', 'pattern' => 'admin.articles.*'],
    ['label' => 'Galeri', 'route' => 'admin.galleries.index', 'pattern' => 'admin.galleries.*'],
    ['label' => 'Testimoni', 'route' => 'admin.testimonials.index', 'pattern' => 'admin.testimonials.*'],
    ['label' => 'Tim', 'route' => 'admin.teams.index', 'pattern' => 'admin.teams.*'],
    ['label' => 'Layanan', 'route' => 'admin.services.index', 'pattern' => 'admin.services.*'],
    ['label' => 'Tentang', 'route' => 'admin.about.edit', 'pattern' => 'admin.about.*'],
    ['label' => 'Beranda', 'route' => 'admin.homepage.edit', 'pattern' => 'admin.homepage.*'],
    ['label' => 'Pengaturan', 'route' => 'admin.settings.index', 'pattern' => 'admin.settings.*'],
];
@endphp

<nav class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm">
    @foreach ($adminNav as $item)
        <a href="{{ route($item['route']) }}"
           class="{{ request()->routeIs($item['pattern']) ? 'font-semibold text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100' }}">
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>