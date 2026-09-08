<x-layouts.public :meta-title="($event->title).' | '.setting('site_name')">
    <section class="bg-rose-700 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block text-xs uppercase tracking-widest bg-white/20 text-white px-4 py-1.5 rounded-full font-semibold">{{ str_replace('_', ' ', $event->event_type) }}</span>
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mt-4">{{ $event->title }}</h1>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2">
                @if($event->image)
                    <div class="rounded-2xl overflow-hidden shadow-lg mb-8">
                        <img src="{{ image_url($event->image) }}" alt="{{ $event->title }}" class="w-full h-80 object-cover" loading="lazy">
                    </div>
                @endif
                @if($event->description)
                    <h2 class="font-display text-2xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-4">Detail Acara</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Tanggal</dt>
                            <dd class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}</dd>
                        </div>
                        @if($event->end_date && $event->end_date != $event->start_date)
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Sampai</dt>
                                <dd class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}</dd>
                            </div>
                        @endif
                        @if($event->start_time)
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Waktu</dt>
                                <dd class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}{{ $event->end_time ? ' - '.\Carbon\Carbon::parse($event->end_time)->format('H:i') : '' }}</dd>
                            </div>
                        @endif
                    </dl>
                    @if($event->venue)
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ $event->venue->name }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $event->venue->address }}</p>
                        </div>
                    @endif
                </div>

                @php
                    $waNum = setting('whatsapp_number', '6281234567890');
                    $waMsg = "Halo, saya ingin bertanya tentang acara " . $event->title;
                @endphp
                <a href="{{ route('contact') }}" class="block w-full text-center py-3 bg-rose-700 hover:bg-rose-800 text-white font-semibold rounded-lg transition">
                    Daftar / Konsultasi
                </a>
                <a href="{{ whatsapp_link($waNum, $waMsg) }}" target="_blank" class="block w-full text-center py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                    Chat WhatsApp
                </a>
            </aside>
        </div>
    </div>
</x-layouts.public>
