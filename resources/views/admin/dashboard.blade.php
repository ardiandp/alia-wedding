<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>

        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('admin.leads.index', ['status' => 'new']) }}"
                   class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Prospek Baru</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $newLeadsCount }}</p>
                </a>

                <a href="{{ route('admin.leads.index', ['status' => 'consultation']) }}"
                   class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dalam Konsultasi</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $consultationCount }}</p>
                </a>

                <a href="{{ route('admin.leads.index', ['status' => 'confirmed']) }}"
                   class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pernikahan Terkonfirmasi</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $confirmedCount }}</p>
                </a>

                <a href="{{ route('admin.events.index') }}"
                   class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:shadow dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Agenda Mendatang</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $upcomingEventsCount }}</p>
                </a>
            </div>

            <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Prospek Terbaru</h3>
                    <a href="{{ route('admin.leads.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/40">
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">WhatsApp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal Pernikahan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Ditugaskan ke</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentLeads as $lead)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $lead->full_name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $lead->whatsapp }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $lead->wedding_date ? $lead->wedding_date->format('d M Y') : '—' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $lead->status === 'new' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : ($lead->status === 'confirmed' || $lead->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300') }}">
                                            {{ Str::title(str_replace('_', ' ', $lead->status)) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $lead->assignedTo?->name ?? 'Belum ada' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada prospek.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Pernikahan Mendatang</h3>
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($upcomingWeddings as $lead)
                            <li class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $lead->full_name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $lead->venue?->name ?? 'Venue belum ditentukan' }}</p>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $lead->wedding_date->format('d M Y') }}</p>
                            </li>
                        @empty
                            <li class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada pernikahan yang dijadwalkan.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Konsultasi Mendatang</h3>
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($upcomingConsultations as $consultation)
                            <li class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $consultation->lead?->full_name ?? 'Tanpa lead' }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $consultation->lead?->venue?->name ?? 'Venue belum ditentukan' }}</p>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $consultation->scheduled_at->format('d M Y') }}{{ $consultation->scheduled_time ? ' · ' . $consultation->scheduled_time : '' }}</p>
                            </li>
                        @empty
                            <li class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada konsultasi yang dijadwalkan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>