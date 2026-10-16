<x-layouts.public>
    {{-- ============ HERO ============ --}}
    <section class="relative min-h-[85vh] flex items-center overflow-hidden">
        @if(!empty($hero->image))
            <img src="{{ image_url($hero->image) }}" alt="{{ $hero->heading ?? '' }}" class="absolute inset-0 w-full h-full object-cover" loading="eager">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-rose-900 via-rose-800 to-rose-700"></div>
        @endif

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 w-full">
            <div class="max-w-2xl">
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    {{ $hero->heading ?? 'Wujudkan Pernikahan Impian Anda' }}
                </h1>
                <p class="mt-6 text-lg sm:text-xl text-white/90 leading-relaxed">
                    {{ $hero->description ?? 'Venue pernikahan premium dan wedding organizer profesional untuk hari bahagia Anda.' }}
                </p>
                <div class="mt-10 flex flex-col sm:flex-row gap-4">
                    @php
                        $primaryUrl = $hero->cta_primary_url ?? route('venues.index');
                        $secondaryUrl = $hero->cta_secondary_url ?? route('contact');
                    @endphp
                    <a href="{{ $primaryUrl }}" class="inline-flex items-center justify-center px-8 py-4 bg-rose-700 hover:bg-rose-800 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl">
                        {{ $hero->cta_primary_text ?? 'Explore Venue' }}
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ $secondaryUrl }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-full border border-white/30 transition-all duration-300 backdrop-blur-sm">
                        {{ $hero->cta_secondary_text ?? 'Consultation' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ INTRODUCTION ============ --}}
    @if(!empty($intro->title) || !empty($intro->image))
        <section class="py-14 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    @if(!empty($intro->image))
                        <div class="relative rounded-2xl overflow-hidden shadow-xl">
                            <img src="{{ image_url($intro->image) }}" alt="{{ $intro->title ?? '' }}" class="w-full h-80 sm:h-96 object-cover rounded-lg" loading="lazy">
                        </div>
                    @endif
                    <div>
                        @if(!empty($intro->title))
                            <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">{{ $intro->title }}</h2>
                        @endif
                        @if(!empty($intro->description))
                            <p class="mt-6 text-gray-600 leading-relaxed text-lg">{{ $intro->description }}</p>
                        @endif
                        <a href="{{ route('about') }}" class="inline-flex items-center mt-8 text-rose-700 hover:text-rose-800 font-semibold transition">
                            Tentang Kami
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ STATISTICS ============ --}}
    <section class="py-14 sm:py-16 bg-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                    <div class="text-center">
                        <div class="font-display text-4xl sm:text-5xl font-bold text-rose-700">
                            {{ $stat['value'] }}
                        </div>
                        <div class="mt-2 text-sm sm:text-base text-gray-600 font-medium">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ VENUE SHOWCASE ============ --}}
    @if($venues->isNotEmpty())
        <section class="py-14 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Venue Kami</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Pilihan venue terbaik untuk momen spesial Anda</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($venues->take(3) as $venue)
                        <a href="{{ route('venues.show', $venue) }}" class="group block bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ image_url($venue->hero_image) }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </div>
                            <div class="p-6">
                                <h3 class="font-display text-xl font-bold text-gray-900 group-hover:text-rose-700 transition">{{ $venue->name }}</h3>
                                <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                    <span>{{ $venue->capacity ? number_format($venue->capacity, 0, ',', '.') . ' guests' : '-' }}</span>
                                    <span class="capitalize">{{ str_replace('_', ' ', $venue->type) }}</span>
                                </div>
                                <span class="inline-flex items-center mt-4 text-rose-700 font-semibold text-sm transition-all">
                                    Lihat Detail
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
                @if($venues->count() > 3)
                    <div class="mt-10 text-center">
                        <a href="{{ route('venues.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-full transition-all duration-300">
                            Lihat Semua Venue
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ============ WEDDING SERVICES ============ --}}
    @if($services->isNotEmpty())
        <section class="py-14 sm:py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Layanan Kami</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Layanan lengkap untuk mewujudkan pernikahan impian Anda</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach($services as $service)
                        <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-lg transition-all duration-300 group">
                            <div class="w-14 h-14 mx-auto rounded-full bg-rose-50 group-hover:bg-rose-100 flex items-center justify-center transition">
                                <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ $service->name }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ WEDDING PACKAGES ============ --}}
    @if($packages->isNotEmpty())
        <section class="py-14 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Paket Pernikahan</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Pilih paket terbaik sesuai kebutuhan dan anggaran Anda</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($packages as $package)
                        <div class="relative flex flex-col bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 {{ $package->is_featured ? 'ring-2 ring-rose-500' : '' }}">
                            @if($package->is_featured)
                                <div class="absolute top-4 right-4 z-10 bg-rose-700 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Populer</div>
                            @endif
                            @if($package->image)
                                <div class="h-44 overflow-hidden">
                                    <img src="{{ image_url($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                            @endif
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="font-display text-xl font-bold text-gray-900">{{ $package->name }}</h3>
                                @if($package->description)
                                    <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $package->description }}</p>
                                @endif
                                @if($package->items->isNotEmpty())
                                    <ul class="mt-6 space-y-2 flex-1">
                                        @foreach($package->items->take(5) as $item)
                                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                {{ $item->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="mt-6 pt-4 border-t border-gray-100">
                                    @if($package->price)
                                        @if($package->price_type === 'starting_from')
                                            <span class="text-xs uppercase tracking-wide text-gray-500">Mulai dari</span>
                                        @endif
                                        <span class="block text-2xl font-bold text-rose-700">{{ format_rupiah($package->price) }}</span>
                                    @else
                                        <span class="text-2xl font-bold text-rose-700">Custom</span>
                                    @endif
                                </div>
                                <a href="{{ route('packages.show', $package) }}" class="mt-6 block w-full text-center py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-lg transition-all duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ REAL WEDDING (Phase 2) ============ --}}
    <section class="py-14 sm:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Real Wedding</h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Cerita pernikahan indah dari pasangan yang telah mempercayakan hari spesial mereka kepada kami</p>
            <div class="mt-12 py-20 border-2 border-dashed border-gray-300 rounded-2xl">
                <p class="text-gray-400 font-medium">Segera hadir di Alia Wedding</p>
            </div>
        </div>
    </section>

    {{-- ============ GALLERY PREVIEW ============ --}}
    @if($galleries->isNotEmpty())
        <section class="py-14 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Galeri Kami</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Momen-momen indah yang telah kami abadikan</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($galleries as $index => $image)
                        <a href="{{ route('gallery.index') }}" class="relative group overflow-hidden rounded-xl {{ $index === 0 ? 'sm:col-span-2 sm:row-span-2' : '' }}">
                            <div class="{{ $index === 0 ? 'h-64 sm:h-full' : 'h-48 sm:h-56' }}">
                                <img src="{{ image_url($image->image) }}" alt="{{ $image->title ?? '' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-full transition-all duration-300">
                        Lihat Semua Galeri
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ TESTIMONIAL CAROUSEL ============ --}}
    @if($featuredTestimonials->isNotEmpty())
        <section class="py-14 sm:py-20 bg-rose-50" x-data="testimonialCarousel()">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Testimoni</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Kata mereka yang telah mempercayakan hari bahagianya kepada kami</p>
                </div>
                <div class="relative max-w-4xl mx-auto">
                    <div class="overflow-hidden rounded-2xl">
                        <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentIndex * 100}%)`">
                            @foreach($featuredTestimonials as $testimonial)
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="bg-white rounded-2xl p-8 sm:p-10 shadow-md text-center">
                                        <div class="flex justify-center mb-4">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                        <p class="text-gray-700 text-lg italic leading-relaxed">"{{ $testimonial->testimonial }}"</p>
                                        <div class="mt-6 flex items-center justify-center gap-3">
                                            @if($testimonial->photo)
                                                <img src="{{ image_url($testimonial->photo) }}" alt="{{ $testimonial->customer_name }}" class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                                                    <span class="text-rose-700 font-semibold text-sm">{{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                            <div class="text-left">
                                                <p class="font-semibold text-gray-900 text-sm">{{ $testimonial->customer_name }} & {{ $testimonial->partner_name }}</p>
                                                @if($testimonial->venue)
                                                    <p class="text-gray-400 text-xs">{{ $testimonial->venue->name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if($featuredTestimonials->count() > 1)
                        <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition hidden sm:flex">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition hidden sm:flex">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <div class="flex justify-center gap-2 mt-6">
                            @foreach($featuredTestimonials as $i => $_)
                                <button @click="goTo({{ $i }})" :class="currentIndex === {{ $i }} ? 'bg-rose-700 w-6' : 'bg-gray-300 w-2'" class="h-2 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ============ UPCOMING AGENDA ============ --}}
    @if($upcomingEvents->isNotEmpty())
        <section class="py-14 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Agenda Mendatang</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Jadwal acara dan event yang akan datang</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                            @if($event->image)
                                <div class="h-44 overflow-hidden">
                                    <img src="{{ image_url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-rose-50 flex flex-col items-center justify-center shrink-0">
                                        <span class="text-xs font-semibold text-rose-600 uppercase">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</span>
                                        <span class="text-lg font-bold text-rose-700 leading-none">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 group-hover:text-rose-700 transition text-sm">{{ $event->title }}</h3>
                                        @if($event->venue)
                                            <p class="text-sm text-gray-500 mt-0.5">{{ $event->venue->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-full transition-all duration-300">
                        Lihat Semua Agenda
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ LATEST ARTICLES ============ --}}
    @if($latestArticles->isNotEmpty())
        <section class="py-14 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900">Berita &amp; Artikel</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Tips dan kabar terbaru seputar pernikahan</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestArticles as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                            @if($article->image)
                                <div class="h-44 overflow-hidden">
                                    <img src="{{ image_url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-xs uppercase tracking-wide text-rose-600 font-semibold">{{ $article->categories->isNotEmpty() ? $article->categories->pluck('name')->join(', ') : 'Artikel' }}</span>
                                <h3 class="mt-2 font-semibold text-gray-900 group-hover:text-rose-700 transition text-sm">{{ $article->title }}</h3>
                                <p class="mt-3 text-xs text-gray-400">{{ $article->published_at?->translatedFormat('d F Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-full transition-all duration-300">
                        Lihat Semua Artikel
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ CONTACT CTA ============ --}}
    <section class="py-14 sm:py-20 bg-rose-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if(!empty($contactCta->title))
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">{{ $contactCta->title }}</h2>
            @endif
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ $contactCta->cta_url ?? route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-rose-700 hover:bg-gray-100 font-semibold rounded-full transition-all duration-300 shadow-lg">
                    {{ $contactCta->cta_text ?? 'Start Your Consultation' }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @php
                    $waNum = setting('whatsapp_number', '6281234567890');
                    $waMsg = setting('whatsapp_message', 'Halo, saya tertarik dengan layanan wedding venue Anda.');
                @endphp
                <a href="{{ whatsapp_link($waNum, $waMsg) }}" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full transition-all duration-300 shadow-lg">
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>

@push('scripts')
<script>
    function testimonialCarousel() {
        return {
            currentIndex: 0,
            total: {{ $featuredTestimonials->count() }},
            autoplay: null,
            init() { this.startAutoplay(); },
            startAutoplay() { this.autoplay = setInterval(() => this.next(), 5000); },
            next() { this.currentIndex = (this.currentIndex + 1) % this.total; },
            prev() { this.currentIndex = this.currentIndex === 0 ? this.total - 1 : this.currentIndex - 1; },
            goTo(index) { this.currentIndex = index; this.stopAutoplay(); this.startAutoplay(); }
        }
    }
</script>
@endpush
