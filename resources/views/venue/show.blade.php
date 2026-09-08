<x-layouts.public :meta-title="($venue->name).' | '.setting('site_name')" :meta-description="$venue->meta_description">
    {{-- Hero --}}
    <section class="relative h-[60vh] overflow-hidden">
        <img src="{{ image_url($venue->hero_image) }}" alt="{{ $venue->name }}" class="w-full h-full object-cover" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white">{{ $venue->name }}</h1>
            <div class="mt-3 flex flex-wrap gap-4 text-white/90 text-sm">
                <span>{{ $venue->capacity ? number_format($venue->capacity, 0, ',', '.') . ' Guests' : '' }}</span>
                @if($venue->size)<span>{{ number_format($venue->size, 0, ',', '.') }} m²</span>@endif
                <span class="capitalize">{{ str_replace('_', ' ', $venue->type) }}</span>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                <h2 class="font-display text-2xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                <p class="text-gray-600 leading-relaxed">{{ $venue->description }}</p>

                {{-- Facilities --}}
                @if($venue->facilities->isNotEmpty())
                    <h2 class="font-display text-2xl font-bold text-gray-900 mt-10 mb-4">Fasilitas</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($venue->facilities as $facility)
                            <div class="flex items-start gap-2 bg-gray-50 rounded-lg p-3">
                                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-gray-700 text-sm">{{ $facility->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Additional Info --}}
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @if($venue->parking)
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h3 class="font-semibold text-gray-900">Parkir</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $venue->parking }}</p>
                        </div>
                    @endif
                    @if($venue->catering)
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h3 class="font-semibold text-gray-900">Catering</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $venue->catering }}</p>
                        </div>
                    @endif
                    @if($venue->decoration)
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h3 class="font-semibold text-gray-900">Decoration</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $venue->decoration }}</p>
                        </div>
                    @endif
                    @if($venue->facility_note)
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h3 class="font-semibold text-gray-900">Facility Note</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $venue->facility_note }}</p>
                        </div>
                    @endif
                </div>

                {{-- Gallery --}}
                @if($venue->images->isNotEmpty())
                    <h2 class="font-display text-2xl font-bold text-gray-900 mt-10 mb-4">Galeri</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($venue->images as $image)
                            <div class="overflow-hidden rounded-lg group">
                                <img src="{{ image_url($image->image) }}" alt="{{ $image->caption ?? $venue->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Location --}}
                <h2 class="font-display text-2xl font-bold text-gray-900 mt-10 mb-4">Lokasi</h2>
                <p class="text-gray-600 mb-4">{{ $venue->address }}</p>
                @if($venue->google_maps_embed)
                    <div class="rounded-xl overflow-hidden">
                        <iframe src="{{ $venue->google_maps_embed }}" class="w-full h-80" style="border:0" loading="lazy" allowfullscreen></iframe>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 sticky top-24">
                    <h3 class="font-display text-lg font-bold text-gray-900">Informasi Venue</h3>
                    <dl class="mt-4 space-y-3 text-sm">
                        @if($venue->capacity)
                            <div class="flex justify-between"><dt class="text-gray-500">Kapasitas</dt><dd class="font-semibold text-gray-900">{{ number_format($venue->capacity, 0, ',', '.') }} guests</dd></div>
                        @endif
                        @if($venue->size)
                            <div class="flex justify-between"><dt class="text-gray-500">Luas</dt><dd class="font-semibold text-gray-900">{{ number_format($venue->size, 0, ',', '.') }} m²</dd></div>
                        @endif
                        <div class="flex justify-between"><dt class="text-gray-500">Tipe</dt><dd class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $venue->type) }}</dd></div>
                    </dl>
                    @if($venue->starting_price)
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <span class="text-sm text-gray-500">Starting From</span>
                            <div class="font-display text-2xl font-bold text-rose-700 mt-1">{{ format_rupiah($venue->starting_price) }}</div>
                        </div>
                    @endif
                    @php
                        $waNum = setting('whatsapp_number', '6281234567890');
                        $waMsg = "Halo, saya tertarik dengan venue " . $venue->name . " untuk pernikahan saya.";
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

                {{-- Related Packages --}}
                @if($venue->packages->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <h3 class="font-display text-lg font-bold text-gray-900 mb-4">Package di Venue Ini</h3>
                        <div class="space-y-3">
                            @foreach($venue->packages as $package)
                                <a href="{{ route('packages.show', $package) }}" class="block p-4 rounded-lg bg-gray-50 hover:bg-rose-50 transition">
                                    <span class="font-semibold text-gray-900 text-sm block">{{ $package->name }}</span>
                                    @if($package->price)
                                        <span class="text-rose-700 font-bold text-sm">{{ format_rupiah($package->price) }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</x-layouts.public>
