<x-admin-layout title="Kategori">
    <x-admin.page-header title="Kategori Artikel"
                          subtitle="{{ $categories->total() }} kategori terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.categories.create')" icon="plus">Tambah Kategori</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$categories">
        <x-slot:head>
            <x-admin.th>Nama</x-admin.th>
            <x-admin.th>Slug</x-admin.th>
            <x-admin.th>Jumlah Artikel</x-admin.th>
            <x-admin.th>Urutan</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($categories as $category)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $category->name }}</x-admin.td>
                    <x-admin.td>{{ $category->slug }}</x-admin.td>
                    <x-admin.td>{{ $category->articles_count }}</x-admin.td>
                    <x-admin.td>{{ $category->sort_order }}</x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.categories.edit', $category)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.categories.destroy', $category)"
                                                  confirm="Hapus kategori ini? Artikel tidak akan terhapus, hanya dilepas dari kategori." />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.empty title="Belum ada kategori"
                                       description="Buat kategori untuk mengelompokkan artikel Anda." icon="folder">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.categories.create')" icon="plus">
                                    Tambah Kategori
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
