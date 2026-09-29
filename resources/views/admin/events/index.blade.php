@php
    $eventTypeLabels = [
        'wedding' => 'Pernikahan',
        'open_house' => 'Open House',
        'expo' => 'Expo',
        'venue_tour' => 'Tur Venue',
        'food_testing' => 'Food Testing',
        'promotion' => 'Promosi',
    ];

    $statusTones = [
        'published' => 'green',
        'cancelled' => 'red',
        'draft' => 'gray',
    ];
@endphp

<x-admin-layout title="Agenda">
    <x-admin.page-header title="Manajemen Agenda"
                          subtitle="{{ $events->total() }} agenda terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.events.create')" icon="plus">Tambah Agenda</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$events">
        <x-slot:head>
            <x-admin.th>Judul</x-admin.th>
            <x-admin.th>Tipe</x-admin.th>
            <x-admin.th>Venue</x-admin.th>
            <x-admin.th>Tanggal Mulai</x-admin.th>
            <x-admin.th>Tanggal Selesai</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($events as $event)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $event->title }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge>
                            {{ $eventTypeLabels[$event->event_type] ?? Str::title(str_replace('_', ' ', $event->event_type)) }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>{{ $event->venue?->name ?? '—' }}</x-admin.td>
                    <x-admin.td>{{ $event->start_date->format('d M Y') }}</x-admin.td>
                    <x-admin.td>{{ $event->end_date?->format('d M Y') ?? '—' }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$statusTones[$event->status] ?? 'gray'">
                            {{ Str::title($event->status) }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.events.edit', $event)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.events.destroy', $event)"
                                                  confirm="Yakin ingin menghapus agenda ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <x-admin.empty title="Belum ada agenda"
                                       description="Buat agenda pertama untuk manages event Anda." icon="calendar">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.events.create')" icon="plus">
                                    Tambah Agenda
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
