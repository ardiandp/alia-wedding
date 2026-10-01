<x-layouts.public :meta-title="'Wedding Package | '.setting('site_name')">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Wedding Package</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">Pilih paket pernikahan terbaik sesuai kebutuhan dan anggaran Anda</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($packages->isNotEmpty())
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
                                <h2 class="font-display text-xl font-bold text-gray-900">{{ $package->name }}</h2>
                                @if($package->guest_capacity)
                                    <p class="mt-1 text-xs text-gray-500">Hingga {{ number_format($package->guest_capacity, 0, ',', '.') }} tamu</p>
                                @endif
                                @if($package->items->isNotEmpty())
                                    <ul class="mt-5 space-y-2 flex-1">
                                        @foreach($package->items->take(6) as $item)
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
                                <a href="{{ route('packages.show', $package) }}" class="mt-5 block w-full text-center py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-lg transition-all duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 text-gray-400 font-medium">Belum ada package tersedia.</div>
            @endif
        </div>
    </section>
</x-layouts.public>
