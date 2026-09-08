<div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
    @forelse ($media as $item)
        @php
            $relPath = media_relative_path($item);
            $relUrl = image_url($relPath);
        @endphp
        <button type="button"
                @click="pick(@js($relPath), @js($relUrl))"
                class="group relative aspect-square overflow-hidden rounded-md ring-1 ring-gray-200 dark:ring-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <img src="{{ $relUrl }}"
                 alt="{{ $item->name }}"
                 class="h-full w-full object-cover transition group-hover:scale-105"
                 loading="lazy">
        </button>
    @empty
        <p class="col-span-full py-8 text-center text-sm text-gray-500">Belum ada media. Upload gambar terlebih dahulu.</p>
    @endforelse
</div>