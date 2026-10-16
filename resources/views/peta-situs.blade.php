<x-layouts.public
    :meta-title="$metaTitle"
    :meta-description="$metaDescription">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Peta Situs</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">
                Daftar lengkap halaman di {{ setting('site_name', 'Alia Wedding') }}.
                Gunakan halaman ini untuk menemukan informasi yang Anda butuhkan.
            </p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            {{-- Halaman Utama --}}
            <div>
                <h2 class="font-display text-2xl font-bold text-gray-900">Halaman</h2>
                <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-4">
                    @foreach ($staticPages as $page)
                        <li>
                            <a href="{{ $page['url'] }}" class="group">
                                <span class="font-semibold text-rose-700 group-hover:text-rose-800 transition">{{ $page['label'] }}</span>
                                <span class="block text-sm text-gray-500">{{ $page['note'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Venue --}}
            @if ($venues->isNotEmpty())
                <div>
                    <h2 class="font-display text-2xl font-bold text-gray-900">Venue</h2>
                    <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-3">
                        @foreach ($venues as $venue)
                            <li>
                                <a href="{{ route('venues.show', $venue) }}" class="text-gray-700 hover:text-rose-700 transition">
                                    {{ $venue->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Paket --}}
            @if ($packages->isNotEmpty())
                <div>
                    <h2 class="font-display text-2xl font-bold text-gray-900">Paket</h2>
                    <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-3">
                        @foreach ($packages as $package)
                            <li>
                                <a href="{{ route('packages.show', $package) }}" class="text-gray-700 hover:text-rose-700 transition">
                                    {{ $package->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Agenda --}}
            @if ($events->isNotEmpty())
                <div>
                    <h2 class="font-display text-2xl font-bold text-gray-900">Agenda</h2>
                    <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-3">
                        @foreach ($events as $event)
                            <li>
                                <a href="{{ route('events.show', $event) }}" class="text-gray-700 hover:text-rose-700 transition">
                                    {{ $event->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Artikel --}}
            @if ($articles->isNotEmpty())
                <div>
                    <h2 class="font-display text-2xl font-bold text-gray-900">Artikel</h2>
                    <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-3">
                        @foreach ($articles as $article)
                            <li>
                                <a href="{{ route('articles.show', $article) }}" class="text-gray-700 hover:text-rose-700 transition">
                                    {{ $article->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Kategori Artikel --}}
            @if ($categories->isNotEmpty())
                <div>
                    <h2 class="font-display text-2xl font-bold text-gray-900">Kategori Artikel</h2>
                    <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-3">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('articles.category', $category) }}" class="text-gray-700 hover:text-rose-700 transition">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
