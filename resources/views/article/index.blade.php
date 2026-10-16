<x-layouts.public :meta-title="($activeCategory?->name ? $activeCategory->name.' | ' : '').'Artikel | '.setting('site_name')"
                  :meta-description="$activeCategory?->description">
    <section class="bg-rose-700 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if($activeCategory)
                <span class="inline-block text-xs uppercase tracking-widest bg-white/20 text-white px-4 py-1.5 rounded-full font-semibold">Kategori</span>
            @endif
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white {{ $activeCategory ? 'mt-4' : '' }}">
                {{ $activeCategory->name ?? 'Artikel & Berita' }}
            </h1>
            <p class="mt-4 text-rose-100">
                {{ $activeCategory?->description ?: 'Informasi, tips, dan kabar terbaru seputar pernikahan' }}
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        @if($categories->isNotEmpty())
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('articles.index') }}"
                   class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium transition {{ ! $activeCategory ? 'bg-rose-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('articles.category', $category) }}"
                       class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium transition {{ $activeCategory && $activeCategory->id === $category->id ? 'bg-rose-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $category->name }}
                        <span class="ml-1.5 text-xs opacity-70">{{ $category->articles_count }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
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
                            <span class="text-xs uppercase tracking-wide text-rose-600 font-semibold">
                                {{ $article->categories->isNotEmpty() ? $article->categories->pluck('name')->join(', ') : 'Artikel' }}
                            </span>
                            <h2 class="mt-2 font-semibold text-gray-900 group-hover:text-rose-700 transition">{{ $article->title }}</h2>
                            @if($article->excerpt)
                                <p class="mt-2 text-sm text-gray-500 line-clamp-3">{{ $article->excerpt }}</p>
                            @endif
                            <p class="mt-4 text-xs text-gray-400">{{ $article->published_at?->translatedFormat('d F Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-400 py-12">Belum ada artikel dalam kategori ini.</p>
        @endif

        <div class="mt-10">
            {{ $articles->links() }}
        </div>
    </div>
</x-layouts.public>
