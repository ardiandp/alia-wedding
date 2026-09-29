@php
    use App\Models\Lead;

    $assignOptions = $staffUsers ?? $users ?? collect();
    $statusOptions = Lead::STATUSES;

    $statusTones = [
        'new' => 'amber',
        'contacted' => 'blue',
        'consultation' => 'brand',
        'proposal_sent' => 'purple',
        'negotiation' => 'purple',
        'confirmed' => 'green',
        'completed' => 'green',
        'cancelled' => 'red',
    ];
@endphp

<x-admin-layout title="Detail Prospek">
    <x-admin.page-header :title="$lead->full_name"
                          :subtitle="trim($lead->email.($lead->whatsapp ? ' · '.$lead->whatsapp : ''))"
                          :back="route('admin.leads.index')">
        <x-slot:actions>
            <x-admin.badge :tone="$statusTones[$lead->status] ?? 'gray'">
                {{ Str::title(str_replace('_', ' ', $lead->status)) }}
            </x-admin.badge>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            <x-admin.card title="Informasi Prospek">
                <dl class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pasangan</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $lead->partner_name ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal Pernikahan</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $lead->wedding_date?->format('d M Y') ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Estimasi Tamu</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $lead->estimated_guests ? $lead->estimated_guests.' orang' : '—' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Venue</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $lead->venue?->name ?? $lead->preferred_venue ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Gaya Pernikahan</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $lead->wedding_style ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Rentang Budget</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $lead->budget_range ?? '—' }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Layanan yang Diminati</dt>
                        <dd class="mt-2">
                            @if ($lead->services->isEmpty())
                                <span class="text-sm text-gray-400">—</span>
                            @else
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($lead->services as $service)
                                        <x-admin.badge tone="brand">{{ $service->name }}</x-admin.badge>
                                    @endforeach
                                </div>
                            @endif
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pesan</dt>
                        <dd class="mt-1 whitespace-pre-line text-sm text-gray-900 dark:text-white">{{ $lead->message ?? '—' }}</dd>
                    </div>
                </dl>
            </x-admin.card>

            <x-admin.card title="Catatan">
                <form method="POST" action="{{ route('admin.leads.notes.store', $lead) }}">
                    @csrf

                    <x-admin.label for="note">Tambah Catatan</x-admin.label>
                    <x-admin.textarea id="note" name="note" rows="3" :value="old('note')" />
                    <x-admin.error name="note" />

                    <div class="mt-3 flex justify-end">
                        <x-admin.button type="submit" icon="plus">Tambah Catatan</x-admin.button>
                    </div>
                </form>

                <div class="mt-5 border-t border-gray-200 pt-5 dark:border-gray-800">
                    @forelse ($lead->notes as $note)
                        <div class="rounded-xl bg-gray-50 p-4 dark:bg-white/[0.03]">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $note->note }}</p>
                            <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                {{ $note->user?->name ?? 'Pengguna' }} · {{ $note->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    @empty
                        <x-admin.empty title="Belum ada catatan" icon="chat" />
                    @endforelse
                </div>
            </x-admin.card>

            <x-admin.card title="Konsultasi">
                <form method="POST" action="{{ route('admin.leads.consultations.store', $lead) }}"
                      class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @csrf

                    <div>
                        <x-admin.label for="scheduled_at" required>Tanggal</x-admin.label>
                        <x-admin.input id="scheduled_at" type="date" name="scheduled_at" :value="old('scheduled_at')" required />
                        <x-admin.error name="scheduled_at" />
                    </div>

                    <div>
                        <x-admin.label for="scheduled_time">Jam</x-admin.label>
                        <x-admin.input id="scheduled_time" name="scheduled_time" :value="old('scheduled_time')"
                                       placeholder="Contoh: 10:00" />
                        <x-admin.error name="scheduled_time" />
                    </div>

                    <div class="sm:col-span-3">
                        <x-admin.label for="consultation_notes">Catatan</x-admin.label>
                        <x-admin.textarea id="consultation_notes" name="notes" rows="2" :value="old('notes')" />
                        <x-admin.error name="notes" />
                    </div>

                    <div class="flex justify-end sm:col-span-3">
                        <x-admin.button type="submit" icon="calendar">Jadwalkan</x-admin.button>
                    </div>
                </form>

                <div class="mt-5 border-t border-gray-200 pt-5 dark:border-gray-800">
                    @forelse ($lead->consultations as $consultation)
                        @php
                            $consultationTone = match ($consultation->status) {
                                'completed' => 'green',
                                'cancelled' => 'red',
                                default => 'blue',
                            };
                        @endphp

                        <div class="flex items-start justify-between gap-4 py-3">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $consultation->scheduled_at->format('d M Y') }}{{ $consultation->scheduled_time ? ' · '.$consultation->scheduled_time : '' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $consultation->notes ?? 'Tanpa catatan' }}</p>
                            </div>

                            <x-admin.badge :tone="$consultationTone" class="shrink-0">
                                {{ Str::title($consultation->status) }}
                            </x-admin.badge>
                        </div>
                    @empty
                        <x-admin.empty title="Belum ada jadwal konsultasi" icon="calendar" />
                    @endforelse
                </div>
            </x-admin.card>
        </div>

        <div class="space-y-5">
            <x-admin.card title="Status">
                <form method="POST" action="{{ route('admin.leads.status', $lead) }}">
                    @csrf
                    @method('PATCH')

                    <x-admin.label for="status">Ubah Status</x-admin.label>
                    <x-admin.select id="status" name="status">
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" @selected($lead->status === $status)>
                                {{ Str::title(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.error name="status" />

                    <x-admin.button type="submit" icon="check" class="mt-4 w-full">Perbarui</x-admin.button>
                </form>
            </x-admin.card>

            <x-admin.card title="Penugasan">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Ditugaskan kepada:
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $lead->assignedTo?->name ?? 'Belum ada' }}</span>
                </p>

                <form method="POST" action="{{ route('admin.leads.assign', $lead) }}" class="mt-4">
                    @csrf
                    @method('PATCH')

                    <x-admin.label for="assigned_to">Tugaskan ke Staf</x-admin.label>
                    <x-admin.select id="assigned_to" name="assigned_to">
                        <option value="">Tidak ada</option>
                        @foreach ($assignOptions as $assignee)
                            <option value="{{ $assignee->id }}" @selected($lead->assigned_to == $assignee->id)>
                                {{ $assignee->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.error name="assigned_to" />

                    <x-admin.button type="submit" icon="check" class="mt-4 w-full">Simpan Penugasan</x-admin.button>
                </form>
            </x-admin.card>

            <x-admin.card title="Riwayat">
                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Dibuat</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $lead->created_at->format('d M Y') }}</dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Kontak Terakhir</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $lead->last_contact_at?->format('d M Y H:i') ?? '—' }}</dd>
                    </div>
                </dl>
            </x-admin.card>
        </div>
    </div>
</x-admin-layout>
