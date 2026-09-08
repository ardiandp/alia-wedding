<x-layouts.public :meta-title="'Tentang Kami | '.setting('site_name')">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">{{ $about->title ?? 'Tentang Kami' }}</h1>
        </div>
    </section>

    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($about)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    @if($about->image)
                        <div class="rounded-2xl overflow-hidden shadow-xl">
                            <img src="{{ image_url($about->image) }}" alt="{{ $about->title ?? 'Tentang Kami' }}" class="w-full h-96 object-cover" loading="lazy">
                        </div>
                    @endif
                    <div>
                        @if($about->description)
                            <p class="text-gray-600 leading-relaxed text-lg">{{ $about->description }}</p>
                        @endif
                        @if($about->company_history)
                            <p class="mt-6 text-gray-600 leading-relaxed">{{ $about->company_history }}</p>
                        @endif
                    </div>
                </div>

                {{-- Vision --}}
                @if($about->vision)
                    <div class="mt-16 text-center max-w-3xl mx-auto">
                        <h2 class="font-display text-3xl font-bold text-gray-900">Visi Kami</h2>
                        <p class="mt-4 text-gray-600 text-lg leading-relaxed">{{ $about->vision }}</p>
                    </div>
                @endif

                {{-- Missions --}}
                @if($about->missions)
                    <div class="mt-16">
                        <h2 class="font-display text-3xl font-bold text-gray-900 text-center">Misi Kami</h2>
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($about->missions as $index => $mission)
                                <div class="bg-rose-50 rounded-2xl p-6 text-center">
                                    <div class="w-12 h-12 mx-auto rounded-full bg-rose-700 text-white flex items-center justify-center font-bold">{{ $index + 1 }}</div>
                                    <p class="mt-4 text-gray-700">{{ $mission }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-20 text-gray-400 font-medium">Belum ada konten profil.</div>
            @endif
        </div>
    </section>
</x-layouts.public>
