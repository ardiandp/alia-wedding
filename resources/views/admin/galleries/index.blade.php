@php
    $images = $galleries ?? $images ?? collect();

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

<x-admin-layout title="Galeri">
    <x-admin.page-header title="Manajemen Galeri"
                          subtitle="{{ $images->total() ?? $images->count() }} galeri terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.galleries.create')" icon="plus">Tambah Galeri</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$images">
        <x-slot:head>
            <x-admin.th>Gambar</x-admin.th>
            <x-admin.th>Judul</x-admin.th>
            <x-admin.th>Kategori</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($images as $gallery)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td>
                        @if ($gallery->image)
                            <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->title }}"
                                 class="h-14 w-20 rounded-xl object-cover">
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </x-admin.td>

                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $gallery->title }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge>
                            {{ $categoryLabels[$gallery->category] ?? Str::title(str_replace('_', ' ', $gallery->category)) }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$gallery->is_active ? 'green' : 'red'">
                            {{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.galleries.edit', $gallery)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.galleries.destroy', $gallery)"
                                                  confirm="Yakin ingin menghapus galeri ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.empty title="Belum ada galeri"
                                       description="Tambahkan foto pertama untuk halaman galeri." icon="photo">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.galleries.create')" icon="plus">
                                    Tambah Galeri
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
