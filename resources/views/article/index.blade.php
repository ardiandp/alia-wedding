<x-layouts.public :meta-title="'Artikel | '.setting('site_name')">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Artikel &amp; Berita</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">Informasi, tips, dan kabar terbaru seputar pernikahan</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($articles->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                        <a href="{{ route('articles.show', $article) }}" class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                            @if($article->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ image_url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-xs uppercase tracking-wide text-rose-600 font-semibold">{{ $article->category ?? 'Artikel' }}</span>
                                <h2 class="mt-2 font-semibold text-gray-900 group-hover:text-rose-700 transition">{{ $article->title }}</h2>
                                @if($article->excerpt)
                                    <p class="mt-2 text-sm text-gray-500 line-clamp-3">{{ $article->excerpt }}</p>
                                @endif
                                <p class="mt-4 text-xs text-gray-400">{{ $article->published_at?->translatedFormat('d F Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-20 text-gray-400 font-medium">Belum ada artikel.</div>
            @endif
        </div>
    </section>
</x-layouts.public>