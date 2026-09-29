@php
    $roleLabels = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'staff' => 'Staff',
    ];

    $roleTones = [
        'super_admin' => 'purple',
        'admin' => 'brand',
        'staff' => 'gray',
    ];

    $filters = [
        '' => 'Semua Role',
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'staff' => 'Staff',
    ];
@endphp

<x-admin-layout title="Pengguna">
    <x-admin.page-header title="Manajemen Pengguna"
                          subtitle="Kelola akun tim dan hak akses panel admin">
        <x-slot:actions>
            <x-admin.button :href="route('admin.users.create')" icon="plus">Tambah Pengguna</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="space-y-5">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <x-admin.stat label="Super Admin" :value="$counts['super_admin']" icon="star" tone="purple" />
            <x-admin.stat label="Admin" :value="$counts['admin']" icon="user" tone="brand" />
            <x-admin.stat label="Staff" :value="$counts['staff']" icon="users" tone="blue" />
        </div>

        <x-admin.card>
            <x-slot:actions>
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                    <x-admin.select name="role" onchange="this.form.submit()" class="!w-auto !py-2">
                        @foreach ($filters as $value => $label)
                            <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
                        @endforeach
                    </x-admin.select>

                    <x-admin.input name="search" type="search" value="{{ request('search') }}"
                                   placeholder="Cari nama atau email..." class="!w-56 !py-2" />

                    <x-admin.button type="submit" variant="secondary" icon="search">Cari</x-admin.button>
                </form>
            </x-slot:actions>

            <x-admin.table :pagination="$users">
                <x-slot:head>
                    <x-admin.th class="w-12">#</x-admin.th>
                    <x-admin.th>Nama</x-admin.th>
                    <x-admin.th>Email</x-admin.th>
                    <x-admin.th>Role</x-admin.th>
                    <x-admin.th>Bergabung</x-admin.th>
                    <x-admin.th class="!text-right">Aksi</x-admin.th>
                </x-slot:head>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                            <x-admin.td class="text-gray-400">{{ $loop->iteration }}</x-admin.td>

                            <x-admin.td>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-semibold text-white">
                                        {{ collect(explode(' ', $user->name))->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('') ?: 'A' }}
                                    </span>

                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                        @if (auth()->user()->is($user))
                                            <p class="text-xs text-brand-600 dark:text-brand-400">Anda</p>
                                        @endif
                                    </div>
                                </div>
                            </x-admin.td>

                            <x-admin.td class="!text-gray-600 dark:!text-gray-400">{{ $user->email }}</x-admin.td>

                            <x-admin.td>
                                <x-admin.badge :tone="$roleTones[$user->role] ?? 'gray'">
                                    {{ $roleLabels[$user->role] ?? $user->role }}
                                </x-admin.badge>
                            </x-admin.td>

                            <x-admin.td>{{ $user->created_at?->format('d M Y') ?? '—' }}</x-admin.td>

                            <x-admin.td class="!text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.button :href="route('admin.users.edit', $user)" variant="secondary" icon="pencil">
                                        Edit
                                    </x-admin.button>

                                    @unless (auth()->user()->is($user))
                                        <x-admin.delete-action :href="route('admin.users.destroy', $user)"
                                                              icon="trash"
                                                              label="Hapus"
                                                              confirm="Yakin ingin menghapus pengguna ini?" />
                                    @endunless
                                </div>
                            </x-admin.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-admin.empty title="Pengguna tidak ditemukan"
                                               description="Coba ubah filter atau tambahkan pengguna baru.">
                                    <x-slot:action>
                                        <x-admin.button :href="route('admin.users.create')" icon="plus">
                                            Tambah Pengguna
                                        </x-admin.button>
                                    </x-slot:action>
                                </x-admin.empty>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-admin.table>
        </x-admin.card>
    </div>
</x-admin-layout>
