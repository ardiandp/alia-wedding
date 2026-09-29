<x-admin-layout title="Layanan">
    <x-admin.page-header title="Manajemen Layanan"
                          subtitle="{{ $services->total() }} layanan terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.services.create')" icon="plus">Tambah Layanan</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$services">
        <x-slot:head>
            <x-admin.th>Ikon</x-admin.th>
            <x-admin.th>Nama</x-admin.th>
            <x-admin.th>Slug</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($services as $service)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-lg dark:bg-white/[0.06]">
                            {{ $service->icon ?: '—' }}
                        </span>
                    </x-admin.td>

                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $service->name }}</x-admin.td>
                    <x-admin.td>{{ $service->slug }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$service->is_active ? 'green' : 'red'">
                            {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.services.edit', $service)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.services.destroy', $service)"
                                                  confirm="Yakin ingin menghapus layanan ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.empty title="Belum ada layanan"
                                       description="Tambahkan layanan wedding pertama Anda." icon="briefcase">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.services.create')" icon="plus">
                                    Tambah Layanan
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
