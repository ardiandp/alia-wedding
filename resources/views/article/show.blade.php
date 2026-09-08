<x-layouts.public :meta-title="($article->title).' | '.setting('site_name')">
    <section class="bg-rose-700 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if($article->category)
                <span class="inline-block text-xs uppercase tracking-widest bg-white/20 text-white px-4 py-1.5 rounded-full font-semibold">{{ $article->category }}</span>
            @endif
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mt-4">{{ $article->title }}</h1>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <p class="text-sm text-gray-400 mb-8">{{ $article->published_at?->translatedFormat('d F Y') }}</p>

        @if($article->image)
            <div class="rounded-2xl overflow-hidden shadow-lg mb-10">
                <img src="{{ image_url($article->image) }}" alt="{{ $article->title }}" class="w-full h-80 object-cover" loading="lazy">
            </div>
        @endif

        @if($article->excerpt)
            <p class="text-lg text-gray-700 leading-relaxed font-medium mb-6">{{ $article->excerpt }}</p>
        @endif

        <div class="prose prose-rose max-w-none">
            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $article->body }}</p>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('articles.index') }}" class="text-sm font-medium text-rose-700 hover:text-rose-800 transition">
                &larr; Kembali ke Artikel
            </a>
            @php
                $waNum = setting('whatsapp_number', '6281234567890');
                $waMsg = "Halo, saya baru saja membaca artikel \"" . $article->title . "\" dan ingin bertanya lebih lanjut.";
            @endphp
            <a href="{{ route('contact') }}" class="inline-flex items-center px-5 py-2.5 bg-rose-700 hover:bg-rose-800 text-white text-sm font-semibold rounded-full transition">
                Konsultasi
            </a>
            <a href="{{ whatsapp_link($waNum, $waMsg) }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-full transition">
                Chat WhatsApp
            </a>
        </div>
    </div>
</x-layouts.public>