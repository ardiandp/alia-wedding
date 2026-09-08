@php
    $assignOptions = $staffUsers ?? $users ?? collect();
    $statusOptions = \App\Models\Lead::STATUSES;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Detail Prospek') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $lead->full_name }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $lead->email }}{{ $lead->whatsapp ? ' · ' . $lead->whatsapp : '' }}
                    </p>
                </div>
                <a href="{{ route('admin.leads.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Kembali</a>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Informasi Prospek</h4>
                        </div>
                        <dl class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Pasangan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->partner_name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal Pernikahan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->wedding_date?->format('d M Y') ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Estimasi Tamu</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->estimated_guests ? $lead->estimated_guests . ' orang' : '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Venue</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->venue?->name ?? $lead->preferred_venue ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Gaya Pernikahan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->wedding_style ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Rentang Budget</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->budget_range ?? '—' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Layanan yang Diminati</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    @if ($lead->services->isEmpty())
                                        —
                                    @else
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($lead->services as $service)
                                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $service->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Pesan</dt>
                                <dd class="mt-1 whitespace-pre-line text-sm text-gray-900 dark:text-gray-100">{{ $lead->message ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Catatan</h4>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.leads.notes.store', $lead) }}" class="mb-6">
                                @csrf
                                <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tambah Catatan</label>
                                <textarea id="note" name="note" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('note') }}</textarea>
                                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                                <div class="mt-3 flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                                        Tambah Catatan
                                    </button>
                                </div>
                            </form>

                            @if ($lead->notes->isEmpty())
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada catatan.</p>
                            @else
                                <ul class="space-y-4">
                                    @foreach ($lead->notes as $note)
                                        <li class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900/40">
                                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $note->note }}</p>
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $note->user?->name ?? 'Pengguna' }} · {{ $note->created_at->format('d M Y H:i') }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Konsultasi</h4>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.leads.consultations.store', $lead) }}" class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                @csrf
                                <div>
                                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                                    <input id="scheduled_at" type="date" name="scheduled_at" value="{{ old('scheduled_at') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="scheduled_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam</label>
                                    <input id="scheduled_time" type="text" name="scheduled_time" value="{{ old('scheduled_time') }}"
                                           placeholder="Contoh: 10:00"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    <x-input-error :messages="$errors->get('scheduled_time')" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="consultation_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                    <textarea id="consultation_notes" name="notes" rows="2"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('notes') }}</textarea>
                                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                </div>
                                <div class="flex justify-end sm:col-span-3" style="margin-top:0">
                                    <button type="submit"
                                            class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                                        Jadwalkan
                                    </button>
                                </div>
                            </form>

                            @if ($lead->consultations->isEmpty())
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada jadwal konsultasi.</p>
                            @else
                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($lead->consultations as $consultation)
                                        <li class="flex items-start justify-between py-3">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $consultation->scheduled_at->format('d M Y') }}{{ $consultation->scheduled_time ? ' · ' . $consultation->scheduled_time : '' }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $consultation->notes ?? 'Tanpa catatan' }}</p>
                                            </div>
                                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300') }}">
                                                {{ Str::title($consultation->status) }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Status</h4>
                        </div>
                        <div class="p-6">
                            <span class="mb-4 inline-flex rounded-full px-3 py-1 text-sm font-medium {{ $lead->status === 'confirmed' || $lead->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : ($lead->status === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300') }}">
                                {{ Str::title(str_replace('_', ' ', $lead->status)) }}
                            </span>
                            <form method="POST" action="{{ route('admin.leads.status', $lead) }}">
                                @csrf
                                @method('PATCH')
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubah Status</label>
                                <select id="status" name="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    @foreach ($statusOptions as $status)
                                        <option value="{{ $status }}" @selected($lead->status === $status)>{{ Str::title(str_replace('_', ' ', $status)) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                <button type="submit"
                                        class="mt-4 inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                                    Perbarui
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Penugasan</h4>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Ditugaskan kepada:
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $lead->assignedTo?->name ?? 'Belum ada' }}</span>
                            </p>
                            <form method="POST" action="{{ route('admin.leads.assign', $lead) }}" class="mt-4">
                                @csrf
                                @method('PATCH')
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tugaskan ke Staf</label>
                                <select id="assigned_to" name="assigned_to"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    <option value="">Tidak ada</option>
                                    @foreach ($assignOptions as $user)
                                        <option value="{{ $user->id }}" @selected($lead->assigned_to == $user->id)>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                                <button type="submit"
                                        class="mt-4 inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                                    Simpan Penugasan
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Dibuat</dt>
                                <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $lead->created_at->format('d M Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Kontak Terakhir</dt>
                                <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $lead->last_contact_at?->format('d M Y H:i') ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>