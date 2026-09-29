<x-admin-layout title="Venue">
    <x-admin.page-header title="Manajemen Venue"
                          subtitle="{{ $venues->total() }} venue terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.venues.create')" icon="plus">Tambah Venue</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$venues">
        <x-slot:head>
            <x-admin.th>Nama</x-admin.th>
            <x-admin.th>Kapasitas</x-admin.th>
            <x-admin.th>Tipe</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($venues as $venue)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $venue->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $venue->images_count }} foto · {{ $venue->facilities_count }} fasilitas
                        </p>
                    </x-admin.td>

                    <x-admin.td>{{ $venue->capacity ? $venue->capacity.' orang' : '—' }}</x-admin.td>

                    <x-admin.td>
                        {{ $venue->type === 'indoor_outdoor' ? 'Indoor & Outdoor' : Str::title($venue->type) }}
                    </x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$venue->is_active ? 'green' : 'red'">
                            {{ $venue->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.venues.edit', $venue)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.venues.destroy', $venue)"
                                                  confirm="Yakin ingin menghapus venue ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.empty title="Belum ada venue"
                                       description="Tambahkan venue pertama untuk mulai mengkatalog." icon="building">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.venues.create')" icon="plus">
                                    Tambah Venue
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
