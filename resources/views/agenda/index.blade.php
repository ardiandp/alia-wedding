<x-layouts.public :meta-title="'Agenda | '.setting('site_name')">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Agenda Kami</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">Jadwal acara, open house, dan event yang akan datang</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($events->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                            @if($event->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ image_url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-lg bg-rose-50 flex flex-col items-center justify-center shrink-0">
                                        <span class="text-xs font-semibold text-rose-600 uppercase">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</span>
                                        <span class="text-lg font-bold text-rose-700 leading-none">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs uppercase tracking-wide text-rose-600 font-semibold">{{ str_replace('_', ' ', $event->event_type) }}</span>
                                        <h2 class="font-semibold text-gray-900 group-hover:text-rose-700 transition">{{ $event->title }}</h2>
                                        @if($event->venue)
                                            <p class="text-sm text-gray-500 mt-0.5">{{ $event->venue->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-20 text-gray-400 font-medium">Belum ada agenda.</div>
            @endif
        </div>
    </section>
</x-layouts.public>
