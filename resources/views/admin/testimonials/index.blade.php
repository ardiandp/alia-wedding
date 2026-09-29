<x-admin-layout title="Testimoni">
    <x-admin.page-header title="Manajemen Testimoni"
                          subtitle="{{ $testimonials->total() }} testimoni terdaftar">
        <x-slot:actions>
            <x-admin.button :href="route('admin.testimonials.create')" icon="plus">Tambah Testimoni</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.table :pagination="$testimonials">
        <x-slot:head>
            <x-admin.th>Pasangan</x-admin.th>
            <x-admin.th>Rating</x-admin.th>
            <x-admin.th>Venue</x-admin.th>
            <x-admin.th>Tanggal Pernikahan</x-admin.th>
            <x-admin.th>Unggulan</x-admin.th>
            <x-admin.th>Status</x-admin.th>
            <x-admin.th class="!text-right">Aksi</x-admin.th>
        </x-slot:head>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($testimonials as $testimonial)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <x-admin.td>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $testimonial->customer_name }}</p>
                        @if ($testimonial->partner_name)
                            <p class="text-xs text-gray-500 dark:text-gray-400">&amp; {{ $testimonial->partner_name }}</p>
                        @endif
                    </x-admin.td>

                    <x-admin.td>
                        <x-admin.badge tone="amber">
                            {{ $testimonial->rating }}/5
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>{{ $testimonial->venue?->name ?? '—' }}</x-admin.td>
                    <x-admin.td>{{ $testimonial->wedding_date?->format('d M Y') ?? '—' }}</x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$testimonial->is_featured ? 'amber' : 'gray'">
                            {{ $testimonial->is_featured ? 'Unggulan' : 'Biasa' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td>
                        <x-admin.badge :tone="$testimonial->is_active ? 'green' : 'red'">
                            {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-admin.badge>
                    </x-admin.td>

                    <x-admin.td class="!text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-admin.button :href="route('admin.testimonials.edit', $testimonial)" variant="secondary" icon="pencil">
                                Edit
                            </x-admin.button>

                            <x-admin.delete-action :href="route('admin.testimonials.destroy', $testimonial)"
                                                  confirm="Yakin ingin menghapus testimoni ini?" />
                        </div>
                    </x-admin.td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <x-admin.empty title="Belum ada testimoni"
                                       description="Tambahkan testimoni pasangan pertama Anda." icon="star">
                            <x-slot:action>
                                <x-admin.button :href="route('admin.testimonials.create')" icon="plus">
                                    Tambah Testimoni
                                </x-admin.button>
                            </x-slot:action>
                        </x-admin.empty>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table>
</x-admin-layout>
