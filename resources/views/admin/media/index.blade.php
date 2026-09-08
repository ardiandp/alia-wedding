<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Media Library') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <div x-data="mediaUploader({
                uploadUrl: @js(route('admin.media.store'))
            })" class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 p-6 dark:bg-gray-800 dark:ring-gray-700"
               @upload-success.window="window.location.reload()">
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3">Upload Media</h3>
                <div class="flex items-center gap-4">
                    <label class="relative inline-flex cursor-pointer items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Pilih Gambar
                        <input type="file" accept="image/jpeg,image/png,image/webp"
                               class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                               @change="upload($event)">
                    </label>
                    <span x-show="uploading" class="text-sm text-gray-500 dark:text-gray-400">Mengupload…</span>
                    <span x-show="error" x-text="error" class="text-sm text-red-600 dark:text-red-400"></span>
                </div>
                <p class="mt-2 text-xs text-gray-400">JPG, PNG, atau WebP maksimal 10 MB. Gambar tersimpan di penyimpanan lokal dan tersedia untuk dipakai di semua halaman.</p>
            </div>

            <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Semua Media ({{ $media->total() }})</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                        @forelse ($media as $item)
                            <div class="group relative overflow-hidden rounded-md ring-1 ring-gray-200 dark:ring-gray-700">
                                <div class="aspect-square">
                                    <a href="{{ image_url(media_relative_path($item)) }}" target="_blank" class="block h-full w-full">
                                        <img src="{{ image_url(media_relative_path($item)) }}"
                                             alt="{{ $item->name }}"
                                             class="h-full w-full object-cover"
                                             loading="lazy">
                                    </a>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-200 px-2 py-1.5 dark:border-gray-700">
                                    <span class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $item->name }}</span>
                                    <form method="POST" action="{{ route('admin.media.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus media ini? File terkait akan ikut dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs font-medium text-red-600 hover:text-red-500 dark:text-red-400">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full py-10 text-center text-sm text-gray-500">Media library masih kosong.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $media->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>