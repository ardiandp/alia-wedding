<x-admin-layout title="Artikel">
    <x-admin.page-header title="Manajemen Artikel"
                          subtitle="{{ $articles->total() }} artikel terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.articles.create')" icon="plus">Tambah Artikel</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$articles">
        <x-slot:head>
            <x-admin.th>Judul</x-admin.th>
            <x-admin.th>Kategori</x-admin.th>
            <x-admin.th>Tanggal Terbit</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($articles as $article)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $article->title }}</x-admin.td>
                    <x-admin.td>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse ($article->categories as $category)
                                <x-admin.badge tone="gray">{{ $category->name }}</x-admin.badge>
                            @empty
                                <span class="text-gray-400 dark:text-gray-600">—</span>
                            @endforelse
                        </div>
                    </x-admin.td>
                    <x-admin.td>{{ $article->published_at?->format('d M Y') ?? '—' }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$article->status === 'published' ? 'green' : 'gray'">
                            {{ $article->status === 'published' ? 'Terbit' : 'Draf' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.articles.edit', $article)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.articles.destroy', $article)"
                                                  confirm="Yakin ingin menghapus artikel ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.empty title="Belum ada artikel"
                                       description="Mulai tulis artikel pertama Anda." icon="document">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.articles.create')" icon="plus">
                                    Tambah Artikel
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
