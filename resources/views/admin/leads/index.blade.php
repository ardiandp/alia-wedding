@php
    use App\Models\Lead;

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

<x-admin-layout title="Prospek">
    <x-admin.page-header title="Manajemen Prospek"
                          subtitle="{{ $leads->total() }} prospek ditemukan">
        <x-slot:actions>
            <form method="GET" action="{{ route('admin.leads.index') }}" class="flex flex-wrap items-center gap-2">
                <x-admin.select name="status" onchange="this.form.submit()" class="!w-auto !py-2">
                    <option value="all" @selected(! request('status') || request('status') === 'all')>Semua Status</option>
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ Str::title(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </x-admin.select>

                <x-admin.button type="submit" variant="secondary" icon="search">Filter</x-admin.button>

                @if (request('status') && request('status') !== 'all')
                    <x-admin.button :href="route('admin.leads.index')" variant="ghost">Hapus Filter</x-admin.button>
                @endif
            </form>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$leads">
        <x-slot:head>
            <x-admin.th>Nama</x-admin.th>
            <x-admin.th>Email</x-admin.th>
            <x-admin.th>WhatsApp</x-admin.th>
            <x-admin.th>Tanggal Pernikahan</x-admin.th>
            <x-admin.th>Venue</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th>Ditugaskan ke</x-admin.th>
            <x-admin.th>Kontak Terakhir</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($leads as $lead)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $lead->full_name }}</x-admin.td>
                    <x-admin.td>{{ $lead->email }}</x-admin.td>
                    <x-admin.td>{{ $lead->whatsapp }}</x-admin.td>
                    <x-admin.td>{{ $lead->wedding_date?->format('d M Y') ?? '—' }}</x-admin.td>
                    <x-admin.td>{{ $lead->venue?->name ?? '—' }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$statusTones[$lead->status] ?? 'gray'">
                            {{ Str::title(str_replace('_', ' ', $lead->status)) }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>{{ $lead->assignedTo?->name ?? 'Belum ada' }}</x-admin.td>
                    <x-admin.td>{{ $lead->last_contact_at?->format('d M Y H:i') ?? '—' }}</x-admin.td>

                    <x-admin.td class="!text-right">
                        <x-admin.button :href="route('admin.leads.show', $lead)" variant="secondary" icon="eye">
                            Lihat
                        </x-admin.button>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">
                        <x-admin.empty title="Belum ada prospek"
                                       description="Prospek dari form kontak akan muncul di sini." icon="target" />
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
