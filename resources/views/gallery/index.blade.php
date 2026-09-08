<x-layouts.public :meta-title="'Gallery | '.setting('site_name')">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Galeri Kami</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">Momen-momen indah yang telah kami abadikan</p>
        </div>
    </section>

    {{-- Category filter --}}
    <section class="bg-white pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('gallery.index') }}" class="px-5 py-2 rounded-full text-sm font-medium border transition {{ !$category ? 'bg-rose-700 text-white border-rose-700' : 'border-gray-300 text-gray-600 hover:border-rose-500 hover:text-rose-700' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('gallery.index', ['category' => $cat]) }}" class="px-5 py-2 rounded-full text-sm font-medium border capitalize transition {{ $category === $cat ? 'bg-rose-700 text-white border-rose-700' : 'border-gray-300 text-gray-600 hover:border-rose-500 hover:text-rose-700' }}">
                    {{ str_replace('_', ' ', $cat) }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Grid --}}
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($images->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($images as $image)
                        <div class="group relative overflow-hidden rounded-xl">
                            <img src="{{ image_url($image->image) }}" alt="{{ $image->title ?? '' }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <span class="text-white text-sm font-medium capitalize">{{ $image->title ?: str_replace('_', ' ', $image->category) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $images->links() }}
                </div>
            @else
                <div class="text-center py-20 text-gray-400 font-medium">Belum ada foto pada kategori ini.</div>
            @endif
        </div>
    </section>
</x-layouts.public>
