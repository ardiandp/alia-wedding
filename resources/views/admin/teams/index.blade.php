<x-admin-layout title="Tim">
    <x-admin.page-header title="Manajemen Tim"
                          subtitle="{{ $teams->total() }} anggota terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.teams.create')" icon="plus">Tambah Anggota</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$teams">
        <x-slot:head>
            <x-admin.th>Foto</x-admin.th>
            <x-admin.th>Nama</x-admin.th>
            <x-admin.th>Posisi</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($teams as $team)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td>
                        @if ($team->photo)
                            <img src="{{ asset('storage/'.$team->photo) }}" alt="{{ $team->name }}"
                                 class="h-12 w-12 rounded-full object-cover">
                        @else
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-500 dark:bg-white/[0.06] dark:text-gray-400">
                                {{ strtoupper(substr($team->name, 0, 1)) }}
                            </span>
                        @endif
                    </x-admin.td>

                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $team->name }}</x-admin.td>
                    <x-admin.td>{{ $team->position }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$team->is_active ? 'green' : 'red'">
                            {{ $team->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.teams.edit', $team)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.teams.destroy', $team)"
                                                  confirm="Yakin ingin menghapus anggota ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.empty title="Belum ada anggota tim"
                                       description="Tambahkan anggota tim pertama Anda." icon="users">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.teams.create')" icon="plus">
                                    Tambah Anggota
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
