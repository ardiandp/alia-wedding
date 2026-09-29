<x-admin-layout title="Paket">
    <x-admin.page-header title="Manajemen Paket"
                          subtitle="{{ $packages->total() }} paket terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.packages.create')" icon="plus">Tambah Paket</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$packages">
        <x-slot:head>
            <x-admin.th>Nama</x-admin.th>
            <x-admin.th>Venue</x-admin.th>
            <x-admin.th>Harga</x-admin.th>
            <x-admin.th>Tipe Harga</x-admin.th>
            <x-admin.th>Item</x-admin.th>
            <x-admin.th>Unggulan</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($packages as $package)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $package->name }}</x-admin.td>

                    <x-admin.td>{{ $package->venue?->name ?? '—' }}</x-admin.td>

                    <x-admin.td>
                        {{ $package->price ? 'Rp '.number_format($package->price, 0, ',', '.') : '—' }}
                    </x-admin.td>

                    <x-admin.td>
                        <x-admin.badge>
                            {{ $package->price_type === 'starting_from' ? 'Mulai Dari' : ($package->price_type === 'fixed' ? 'Tertentu' : 'Custom') }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>{{ $package->items_count }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$package->is_featured ? 'amber' : 'gray'">
                            {{ $package->is_featured ? 'Unggulan' : 'Biasa' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$package->is_active ? 'green' : 'red'">
                            {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.packages.edit', $package)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.packages.destroy', $package)"
                                                  confirm="Yakin ingin menghapus paket ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <x-admin.empty title="Belum ada paket"
                                       description="Buat paket wedding pertama Anda." icon="tag">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.packages.create')" icon="plus">
                                    Tambah Paket
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
