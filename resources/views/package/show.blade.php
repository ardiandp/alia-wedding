<x-layouts.public :meta-title="($package->name).' | '.setting('site_name')" :meta-description="$package->meta_description">
    {{-- Header --}}
    <section class="bg-rose-700 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white">{{ $package->name }}</h1>
            @if($package->guest_capacity)
                <p class="mt-3 text-white/80">Untuk hingga {{ number_format($package->guest_capacity, 0, ',', '.') }} tamu</p>
            @endif
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Main --}}
            <div class="lg:col-span-2">
                @if($package->image)
                    <div class="rounded-2xl overflow-hidden shadow-lg mb-8">
                        <img src="{{ image_url($package->image) }}" alt="{{ $package->name }}" class="w-full h-72 object-cover" loading="lazy">
                    </div>
                @endif
                @if($package->description)
                    <h2 class="font-display text-2xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $package->description }}</p>
                @endif

                <h2 class="font-display text-2xl font-bold text-gray-900 mt-10 mb-4">Apa yang Termasuk</h2>
                @if($package->items->isNotEmpty())
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($package->items as $item)
                            <li class="flex items-start gap-2 bg-gray-50 rounded-lg p-3">
                                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-gray-700 text-sm">{{ $item->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 sticky top-24">
                    <h3 class="text-sm text-gray-500">Harga</h3>
                    @if($package->price)
                        <div class="font-display text-3xl font-bold text-rose-700 mt-2">{{ format_rupiah($package->price) }}</div>
                        <p class="text-xs text-gray-400 mt-1">{{ $package->price_type === 'starting_from' ? 'Harga mulai dari' : 'Harga tetap' }}</p>
                    @else
                        <div class="font-display text-3xl font-bold text-rose-700 mt-2">Custom</div>
                        <p class="text-xs text-gray-400 mt-1">Cocokkan dengan kebutuhan Anda</p>
                    @endif

                    @if($package->venue)
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            <a href="{{ route('venues.show', $package->venue) }}" class="text-sm text-rose-700 font-medium hover:underline">{{ $package->venue->name }}</a>
                        </div>
                    @endif

                    @php
                        $waNum = setting('whatsapp_number', '6281234567890');
                        $waMsg = "Halo, saya tertarik dengan package " . $package->name . ". Mohon info lebih lanjut.";
                    @endphp
                    <div class="mt-6 space-y-3">
                        <a href="{{ route('contact') }}" class="block w-full text-center py-3 bg-rose-700 hover:bg-rose-800 text-white font-semibold rounded-lg transition">
                            Request Consultation
                        </a>
                        <a href="{{ whatsapp_link($waNum, $waMsg) }}" target="_blank" class="block w-full text-center py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
