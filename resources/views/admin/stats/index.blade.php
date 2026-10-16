<x-admin-layout title="Statistik">
    <x-admin.page-header title="Statistik Pengunjung"
                          subtitle="Trafik situs, halaman populer, dan performa SEO"
                          :back="route('admin.dashboard')">
        <x-slot:actions>
            <div class="inline-flex rounded-xl border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-white/[0.03]">
                @foreach (\App\Support\Analytics::RANGES as $option)
                    <a href="{{ route('admin.stats.index', ['range' => $option]) }}"
                       class="rounded-lg px-3 py-1.5 text-sm font-semibold transition {{ $range === $option
                            ? 'bg-brand-600 text-white'
                            : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/[0.06]' }}">
                        {{ $option }} hari
                    </a>
                @endforeach
            </div>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="space-y-5">
        <!-- Summary -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-admin.stat label="Pengunjung ({{ $range }} hari)"
                          :value="$summary['visitors']"
                          icon="users"
                          tone="brand" />

            <x-admin.stat label="Tampilan Halaman"
                          :value="$summary['views']"
                          icon="eye"
                          tone="blue"
                          :hint="$summary['pages_per_visit'].' halaman / pengunjung'" />

            <x-admin.stat label="Pengunjung Hari Ini"
                          :value="$summary['today_visitors']"
                          icon="chart"
                          tone="green"
                          :hint="$summary['today_views'].' tampilan hari ini'" />

            <x-admin.stat label="Klik CTA"
                          :value="$summary['clicks']"
                          icon="target"
                          tone="amber"
                          hint="WhatsApp, telepon, kontak" />
        </div>

        <!-- Chart -->
        <x-admin.card title="Tren Pengunjung" subtitle="{{ $range }} hari terakhir">
            <x-admin.visitor-chart :series="$series" :height="280" />
        </x-admin.card>

        <!-- Top pages & referrers -->
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            <x-admin.card title="Halaman Terpopuler" subtitle="{{ $range }} hari terakhir" :padded="false">
                <x-admin.table>
                    <x-slot:head>
                        <x-admin.th>Halaman</x-admin.th>
                        <x-admin.th class="!text-right">Pengunjung</x-admin.th>
                        <x-admin.th class="!text-right">Tampilan</x-admin.th>
                    </x-slot:head>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($topPages as $page)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                <x-admin.td>
                                    <span class="block font-medium text-gray-900 dark:text-white">
                                        {{ $page->page_title ?: $page->path }}
                                    </span>
                                    <span class="block text-xs text-gray-400">{{ $page->path }}</span>
                                </x-admin.td>
                                <x-admin.td class="!text-right">{{ number_format($page->visitors, 0, ',', '.') }}</x-admin.td>
                                <x-admin.td class="!text-right">{{ number_format($page->views, 0, ',', '.') }}</x-admin.td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <x-admin.empty title="Belum ada kunjungan"
                                                   description="Data akan muncul setelah ada pengunjung." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-admin.table>
            </x-admin.card>

            <x-admin.card title="Sumber Kunjungan" subtitle="Referrer teratas" :padded="false">
                <x-admin.table>
                    <x-slot:head>
                        <x-admin.th>Sumber</x-admin.th>
                        <x-admin.th class="!text-right">Kunjungan</x-admin.th>
                    </x-slot:head>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($topReferrers as $referrer)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                <x-admin.td class="!font-medium !text-gray-900 dark:!text-white">{{ $referrer->referrer_host }}</x-admin.td>
                                <x-admin.td class="!text-right">{{ number_format($referrer->visits, 0, ',', '.') }}</x-admin.td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <x-admin.empty title="Belum ada sumber kunjungan"
                                                   description="Kunjungan dari Google, media sosial, dan tautan lain tampil di sini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-admin.table>
            </x-admin.card>
        </div>

        <!-- Devices & Clicks -->
        @php
            $clickLabels = [
                'whatsapp' => 'WhatsApp',
                'phone' => 'Telepon',
                'email' => 'Email',
                'contact' => 'Konsultasi / Kontak',
                'cta' => 'CTA Lainnya',
            ];

            $deviceLabels = [
                'desktop' => 'Desktop',
                'mobile' => 'Mobile',
                'tablet' => 'Tablet',
                'unknown' => 'Tidak diketahui',
            ];

            $deviceTotal = max(1, $devices->sum('total'));
        @endphp

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            <x-admin.card title="Perangkat Pengunjung" subtitle="{{ $range }} hari terakhir">
                @forelse ($devices as $device)
                    @php $percentage = round(($device->total / $deviceTotal) * 100); @endphp
                    <div class="mb-4 last:mb-0">
                        <div class="mb-1.5 flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-200">
                                {{ $deviceLabels[$device->device] ?? ucfirst((string) $device->device) }}
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ number_format($device->total, 0, ',', '.') }} ({{ $percentage }}%)
                            </span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-white/[0.05]">
                            <div class="h-full rounded-full bg-brand-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <x-admin.empty title="Belum ada data perangkat" description="Data perangkat tampil setelah ada kunjungan." />
                @endforelse
            </x-admin.card>

            <x-admin.card title="Klik Tombol (CTA)" subtitle="{{ $range }} hari terakhir">
                @forelse ($clickCounts as $label => $total)
                    <div class="flex items-center justify-between border-b border-gray-100 py-3 last:border-0 dark:border-gray-800">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ $clickLabels[$label] ?? ucfirst($label) }}
                        </span>
                        <x-admin.badge tone="amber">{{ number_format($total, 0, ',', '.') }} klik</x-admin.badge>
                    </div>
                @empty
                    <x-admin.empty title="Belum ada klik CTA"
                                   description="Klik pada tombol WhatsApp, telepon, atau kontak akan tercatat di sini." />
                @endforelse
            </x-admin.card>
        </div>

        <!-- Google Search Console -->
        <x-admin.card title="Google Search Console" subtitle="Klik, impresi, dan CTR dari hasil pencarian Google">
            @php $gscEmbed = setting('analytics_gsc_embed_url'); @endphp

            <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                Jumlah klik, impresi, dan CTR dari hasil pencarian Google hanya tersedia di Google Search Console.
                Buka panel GSC untuk melihat metrik tersebut. Untuk menampilkannya langsung di sini, tempel URL embed
                laporan (misalnya dari Looker Studio) pada pengaturan <strong>Analitik</strong>.
            </p>

            <div class="flex flex-wrap items-center gap-3">
                <x-admin.button href="https://search.google.com/search-console" target="_blank" rel="noopener" icon="search">
                    Buka Google Search Console
                </x-admin.button>

                <x-admin.button :href="route('admin.settings.index')" variant="secondary" icon="cog">
                    Atur Embed Laporan
                </x-admin.button>
            </div>

            @if ($gscEmbed)
                <div class="mt-5 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                    <iframe src="{{ $gscEmbed }}" class="h-[600px] w-full" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endif
        </x-admin.card>
    </div>
</x-admin-layout>
