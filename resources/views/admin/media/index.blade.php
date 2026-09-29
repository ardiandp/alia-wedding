<x-admin-layout title="Media Library">
    <x-admin.page-header title="Media Library"
                          subtitle="Upload dan kelola aset gambar untuk seluruh halaman situs." />

    <div class="space-y-5">
        <x-admin.card title="Upload Media">
            <div x-data="mediaUploader({
                uploadUrl: @js(route('admin.media.store'))
            })" @upload-success.window="window.location.reload()">
                <div class="flex flex-wrap items-center gap-4">
                    <label class="relative inline-flex cursor-pointer items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                        <x-admin.icon name="plus" class="h-4 w-4" />
                        Pilih Gambar

                        <input type="file" accept="image/jpeg,image/png,image/webp"
                               class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                               @change="upload($event)">
                    </label>

                    <span x-show="uploading" class="text-sm text-gray-500 dark:text-gray-400">Mengupload…</span>
                    <span x-show="error" x-text="error" class="text-sm text-red-600 dark:text-red-400"></span>
                </div>

                <p class="mt-3 text-xs text-gray-400">
                    JPG, PNG, atau WebP maksimal 10 MB. Gambar tersimpan di penyimpanan lokal dan tersedia untuk dipakai di semua halaman.
                </p>
            </div>
        </x-admin.card>

        <x-admin.card title="Semua Media" :subtitle="$media->total().' file tersimpan'">
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @forelse ($media as $item)
                    <div class="group overflow-hidden rounded-2xl border border-gray-200 transition hover:border-brand-300 hover:shadow-md dark:border-gray-800 dark:hover:border-brand-500/40">
                        <a href="{{ image_url(media_relative_path($item)) }}" target="_blank" rel="noopener"
                           class="block aspect-square overflow-hidden">
                            <img src="{{ image_url(media_relative_path($item)) }}"
                                 alt="{{ $item->name }}"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </a>

                        <div class="flex items-center justify-between gap-2 border-t border-gray-200 px-3 py-2 dark:border-gray-800">
                            <span class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $item->name }}</span>

                            <form method="POST" action="{{ route('admin.media.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus media ini? File terkait akan ikut dihapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="shrink-0 text-xs font-semibold text-red-600 transition hover:text-red-500 dark:text-red-400">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <x-admin.empty title="Media library masih kosong"
                                       description="Upload gambar pertama Anda melalui form di atas." icon="photo" />
                    </div>
                @endforelse
            </div>

            @if ($media->hasPages())
                <div class="mt-6 border-t border-gray-200 pt-4 dark:border-gray-800">
                    {{ $media->onEachSide(1)->links() }}
                </div>
            @endif
        </x-admin.card>
    </div>
</x-admin-layout>
