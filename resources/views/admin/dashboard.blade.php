<x-admin-layout title="Dashboard">
    <x-admin.page-header title="Dashboard"
                          subtitle="Ringkasan prospek, agenda, dan aktivitas terbaru">
        <x-slot:actions>
            <x-admin.button :href="route('admin.leads.index')" variant="secondary" icon="target">
                Kelola Prospek
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="space-y-5">
        <!-- Stats -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-admin.stat label="Prospek Baru"
                          :value="$newLeadsCount"
                          icon="inbox"
                          tone="amber"
                          :href="route('admin.leads.index', ['status' => 'new'])" />

            <x-admin.stat label="Dalam Konsultasi"
                          :value="$consultationCount"
                          icon="chat"
                          tone="blue"
                          :href="route('admin.leads.index', ['status' => 'consultation'])" />

            <x-admin.stat label="Pernikahan Terkonfirmasi"
                          :value="$confirmedCount"
                          icon="check"
                          tone="green"
                          :href="route('admin.leads.index', ['status' => 'confirmed'])" />

            <x-admin.stat label="Agenda Mendatang"
                          :value="$upcomingEventsCount"
                          icon="calendar"
                          tone="purple"
                          :href="route('admin.events.index')" />
        </div>

        <!-- Recent leads -->
        <x-admin.card title="Prospek Terbaru" subtitle="5 prospek terakhir yang masuk.">
            <x-slot:actions>
                <x-admin.button :href="route('admin.leads.index')" variant="ghost" icon="arrow-right">
                    Lihat Semua
                </x-admin.button>
            </x-slot:actions>

            <x-admin.table>
                <x-slot:head>
                    <x-admin.th>Nama</x-admin.th>
                    <x-admin.th>WhatsApp</x-admin.th>
                    <x-admin.th>Tanggal Pernikahan</x-admin.th>
                    <x-admin.th>Status</x-admin.th>
                    <x-admin.th>Ditugaskan ke</x-admin.th>
                    <x-admin.th class="!text-right">Aksi</x-admin.th>
                </x-slot:head>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($recentLeads as $lead)
                        @php
                            $statusTone = match ($lead->status) {
                                'new' => 'amber',
                                'consultation' => 'blue',
                                'confirmed', 'completed' => 'green',
                                'cancelled' => 'red',
                                default => 'gray',
                            };
                        @endphp

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                            <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">
                                {{ $lead->full_name }}
                            </x-admin.td>

                            <x-admin.td>{{ $lead->whatsapp }}</x-admin.td>

                            <x-admin.td>{{ $lead->wedding_date?->format('d M Y') ?? '—' }}</x-admin.td>

                            <x-admin.td>
                                <x-admin.badge :tone="$statusTone">
                                    {{ Str::title(str_replace('_', ' ', $lead->status)) }}
                                </x-admin.badge>
                            </x-admin.td>

                            <x-admin.td>{{ $lead->assignedTo?->name ?? 'Belum ada' }}</x-admin.td>

                            <x-admin.td class="!text-right">
                                <x-admin.button :href="route('admin.leads.show', $lead)" variant="secondary" icon="eye">
                                    Detail
                                </x-admin.button>
                            </x-admin.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-admin.empty title="Belum ada prospek"
                                               description="Prospek dari form kontak akan muncul di sini.">
                                    <x-slot:action>
                                        <x-admin.button :href="route('admin.leads.index')" variant="secondary" icon="target">
                                            Buka CRM
                                        </x-admin.button>
                                    </x-slot:action>
                                </x-admin.empty>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-admin.table>
        </x-admin.card>

        <!-- Upcoming -->
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <x-admin.card title="Pernikahan Mendatang">
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($upcomingWeddings as $lead)
                        <li class="flex items-center justify-between gap-4 py-3.5 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-gray-900 dark:text-white">{{ $lead->full_name }}</p>
                                <p class="truncate text-sm text-gray-500 dark:text-gray-400">{{ $lead->venue?->name ?? 'Venue belum ditentukan' }}</p>
                            </div>

                            <span class="shrink-0 text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ $lead->wedding_date->format('d M Y') }}
                            </span>
                        </li>
                    @empty
                        <li>
                            <x-admin.empty title="Belum ada pernikahan terjadwal"
                                           description="Jadwal pernikahan terkonfirmasi akan tampil di sini."
                                           icon="calendar" />
                        </li>
                    @endforelse
                </ul>
            </x-admin.card>

            <x-admin.card title="Konsultasi Mendatang">
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($upcomingConsultations as $consultation)
                        <li class="flex items-center justify-between gap-4 py-3.5 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $consultation->lead?->full_name ?? 'Tanpa prospek' }}
                                </p>
                                <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                    {{ $consultation->lead?->venue?->name ?? 'Venue belum ditentukan' }}
                                </p>
                            </div>

                            <span class="shrink-0 text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ $consultation->scheduled_at->format('d M Y') }}{{ $consultation->scheduled_time ? ' · '.$consultation->scheduled_time : '' }}
                            </span>
                        </li>
                    @empty
                        <li>
                            <x-admin.empty title="Belum ada konsultasi terjadwal"
                                           description="Jadwal konsultasi berikutnya akan tampil di sini."
                                           icon="chat" />
                        </li>
                    @endforelse
                </ul>
            </x-admin.card>
        </div>
    </div>
</x-admin-layout>
