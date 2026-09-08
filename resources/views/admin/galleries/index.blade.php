@php
    $images = $galleries ?? $images ?? collect();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Manajemen Galeri') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $images->total() ?? $images->count() }} galeri terdaftar</p>
                <a href="{{ route('admin.galleries.create') }}"
                   class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                    Tambah Galeri
                </a>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/40">
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $categoryLabels = [
                                    'venue' => 'Venue',
                                    'wedding' => 'Pernikahan',
                                    'decoration' => 'Dekorasi',
                                    'reception' => 'Resepsi',
                                    'bride_groom' => 'Pengantin',
                                    'table_setting' => 'Penataan Meja',
                                    'garden' => 'Garden',
                                    'real_wedding' => 'Real Wedding',
                                ];
                            @endphp
                            @forelse ($images as $gallery)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($gallery->image)
                                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}"
                                                 class="h-14 w-20 rounded-md object-cover">
                                        @else
                                            <span class="text-sm text-gray-400 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $gallery->title }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $categoryLabels[$gallery->category] ?? Str::title(str_replace('_', ' ', $gallery->category)) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $gallery->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' }}">
                                            {{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Edit</a>
                                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus galeri ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-3 text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada galeri. <a href="{{ route('admin.galleries.create') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Tambah galeri pertama</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($images, 'hasPages') && $images->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                        {{ $images->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>