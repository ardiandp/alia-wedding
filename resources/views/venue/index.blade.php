<x-layouts.public :meta-title="'Venue | '.setting('site_name')">
    {{-- Header --}}
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Venue Kami</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">Jelajahi pilihan venue premium untuk momen spesial Anda</p>
        </div>
    </section>

    {{-- Filters --}}
    <section class="bg-white pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('venues.index') }}" class="flex flex-col sm:flex-row gap-4 bg-gray-50 p-4 rounded-xl">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari venue..." class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                <select name="type" class="px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                    <option value="">Semua Tipe</option>
                    <option value="indoor" @selected(request('type') === 'indoor')>Indoor</option>
                    <option value="outdoor" @selected(request('type') === 'outdoor')>Outdoor</option>
                    <option value="indoor_outdoor" @selected(request('type') === 'indoor_outdoor')>Indoor & Outdoor</option>
                </select>
                <select name="capacity" class="px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                    <option value="">Semua Kapasitas</option>
                    <option value="100" @selected(request('capacity') == 100)>>= 100</option>
                    <option value="300" @selected(request('capacity') == 300)>>= 300</option>
                    <option value="500" @selected(request('capacity') == 500)>>= 500</option>
                    <option value="800" @selected(request('capacity') == 800)>>= 800</option>
                </select>
                <button type="submit" class="px-6 py-3 bg-rose-700 hover:bg-rose-800 text-white font-semibold rounded-lg transition">Filter</button>
            </form>
        </div>
    </section>

    {{-- Venue Grid --}}
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($venues->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($venues as $venue)
                        <a href="{{ route('venues.show', $venue) }}" class="group block bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ image_url($venue->hero_image) }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-rose-700 capitalize">{{ str_replace('_', ' ', $venue->type) }}</div>
                            </div>
                            <div class="p-6">
                                <h2 class="font-display text-xl font-bold text-gray-900 group-hover:text-rose-700 transition">{{ $venue->name }}</h2>
                                <div class="mt-3 flex items-center gap-4 text-sm text-gray-500">
                                    <span>{{ $venue->capacity ? number_format($venue->capacity, 0, ',', '.') . ' Guests' : '' }}</span>
                                    @if($venue->size)<span>{{ number_format($venue->size, 0, ',', '.') }} m²</span>@endif
                                </div>
                                @if($venue->starting_price)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <span class="text-sm text-gray-500">Starting From</span>
                                        <div class="font-bold text-rose-700">{{ format_rupiah($venue->starting_price) }}</div>
                                    </div>
                                @endif
                                <span class="inline-flex items-center mt-4 text-rose-700 font-semibold text-sm">
                                    Lihat Detail
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $venues->links() }}
                </div>
            @else
                <div class="text-center py-20 text-gray-400 font-medium">Belum ada venue yang tersedia.</div>
            @endif
        </div>
    </section>
</x-layouts.public>
