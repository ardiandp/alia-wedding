@php
    $val = fn ($key) => old($key, $settings->get($key, '') ?? '');
    $checked = fn ($key) => (bool) old($key, $settings->get($key, false));
    $seoTitleConfig = json_encode([
        'titleLimit' => 60,
        'descriptionLimit' => 160,
        'defaultTitle' => (string) $val('seo_default_title'),
        'defaultDescription' => (string) $val('seo_default_description'),
        'previewUrl' => url('/'),
        'metaTitle' => (string) $val('seo_default_title'),
        'metaDescription' => (string) $val('seo_default_description'),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
@endphp

<x-admin-layout title="Pengaturan Website">
    <x-admin.page-header title="Pengaturan Website"
                          subtitle="Konfigurasi informasi, kontak, dan SEO situs"
                          :back="route('admin.dashboard')" />

    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Umum">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="site_name">Nama Situs</x-admin.label>
                    <x-admin.input id="site_name" name="site_name" :value="$val('site_name')" />
                    <x-admin.error name="site_name" />
                </div>

                <div>
                    <x-admin.label for="site_tagline">Tagline</x-admin.label>
                    <x-admin.input id="site_tagline" name="site_tagline" :value="$val('site_tagline')" />
                    <x-admin.error name="site_tagline" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="site_description">Deskripsi Situs</x-admin.label>
                    <x-admin.textarea id="site_description" name="site_description" rows="3" :value="$val('site_description')" />
                    <x-admin.error name="site_description" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Kontak & WhatsApp">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="contact_email">Email Kontak</x-admin.label>
                    <x-admin.input id="contact_email" name="contact_email" type="email" :value="$val('contact_email')" />
                    <x-admin.error name="contact_email" />
                </div>

                <div>
                    <x-admin.label for="contact_phone">Telepon Kontak</x-admin.label>
                    <x-admin.input id="contact_phone" name="contact_phone" :value="$val('contact_phone')" />
                    <x-admin.error name="contact_phone" />
                </div>

                <div>
                    <x-admin.label for="whatsapp_number">Nomor WhatsApp</x-admin.label>
                    <x-admin.input id="whatsapp_number" name="whatsapp_number" :value="$val('whatsapp_number')" placeholder="6281234567890" />
                    <x-admin.error name="whatsapp_number" />
                </div>

                <div>
                    <x-admin.label for="whatsapp_message">Pesan WhatsApp Default</x-admin.label>
                    <x-admin.input id="whatsapp_message" name="whatsapp_message" :value="$val('whatsapp_message')" />
                    <x-admin.error name="whatsapp_message" />
                </div>
            </div>

            <div class="mt-5">
                <x-admin.checkbox name="whatsapp_floating_enabled"
                                  label="Aktifkan Tombol WhatsApp Mengambang"
                                  unchecked="0"
                                  :value="$checked('whatsapp_floating_enabled')" />
            </div>
        </x-admin.card>

        <x-admin.card title="Media Sosial">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="instagram_url">Instagram</x-admin.label>
                    <x-admin.input id="instagram_url" name="instagram_url" type="url"
                                   :value="$val('instagram_url')" placeholder="https://instagram.com/..." />
                    <x-admin.error name="instagram_url" />
                </div>

                <div>
                    <x-admin.label for="facebook_url">Facebook</x-admin.label>
                    <x-admin.input id="facebook_url" name="facebook_url" type="url"
                                   :value="$val('facebook_url')" placeholder="https://facebook.com/..." />
                    <x-admin.error name="facebook_url" />
                </div>

                <div>
                    <x-admin.label for="tiktok_url">TikTok</x-admin.label>
                    <x-admin.input id="tiktok_url" name="tiktok_url" type="url"
                                   :value="$val('tiktok_url')" placeholder="https://tiktok.com/@..." />
                    <x-admin.error name="tiktok_url" />
                </div>

                <div>
                    <x-admin.label for="youtube_url">YouTube</x-admin.label>
                    <x-admin.input id="youtube_url" name="youtube_url" type="url"
                                   :value="$val('youtube_url')" placeholder="https://youtube.com/@..." />
                    <x-admin.error name="youtube_url" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Lokasi">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-admin.label for="address">Alamat</x-admin.label>
                    <x-admin.input id="address" name="address" :value="$val('address')" />
                    <x-admin.error name="address" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="google_maps_embed">Google Maps Embed URL</x-admin.label>
                    <x-admin.input id="google_maps_embed" name="google_maps_embed" type="url"
                                   :value="$val('google_maps_embed')" placeholder="https://www.google.com/maps/embed?pb=..." />
                    <x-admin.error name="google_maps_embed" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="operational_hours">Jam Operasional</x-admin.label>
                    <x-admin.input id="operational_hours" name="operational_hours"
                                   :value="$val('operational_hours')" placeholder="Senin &ndash; Minggu: 09.00 &ndash; 21.00" />
                    <x-admin.error name="operational_hours" />
                </div>
            </div>
        </x-admin.card>

        <div class="space-y-5" x-data="seoFields(@js($seoTitleConfig))">
            <x-admin.card title="SEO Default">
                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                    Nilai ini dipakai pada halaman yang tidak punya pengaturan SEO sendiri,
                    seperti halaman utama, profil, dan daftar venue.
                </p>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <div class="flex items-baseline justify-between gap-3">
                            <x-admin.label for="seo_default_title">Judul SEO Default</x-admin.label>
                            <span class="shrink-0 text-xs" :class="counterClass('title')" x-text="counter('title')"></span>
                        </div>
                        <x-admin.input id="seo_default_title" name="seo_default_title" maxlength="255"
                                       x-model="metaTitle" :value="$val('seo_default_title')" />
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Dipakai sebagai judul cadangan halaman tanpa judul SEO khusus.
                        </p>
                        <x-admin.error name="seo_default_title" />
                    </div>

                    <div>
                        <div class="flex items-baseline justify-between gap-3">
                            <x-admin.label for="seo_default_description">Deskripsi SEO Default</x-admin.label>
                            <span class="shrink-0 text-xs" :class="counterClass('description')" x-text="counter('description')"></span>
                        </div>
                        <x-admin.textarea id="seo_default_description" name="seo_default_description" rows="3"
                                          maxlength="500" x-model="metaDescription"
                                          :value="$val('seo_default_description')" />
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Muncul di bawah judul pada hasil pencarian.
                        </p>
                        <x-admin.error name="seo_default_description" />
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Pratinjau Google" subtitle="Tampilan perkiraan di halaman hasil pencarian">
                <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-950">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400" x-text="previewUrl"></p>
                    <p class="mt-1 truncate text-lg leading-snug text-[#1a0dab] dark:text-[#8ab4f8]"
                       x-text="previewTitle"></p>
                    <p class="mt-1 text-sm text-[#4d5156] dark:text-[#bdc1c6]"
                       x-text="previewDescription"></p>
                </div>
            </x-admin.card>
        </div>

        <x-admin.card title="Gambar Preview & Verifikasi">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-admin.media-picker name="seo_default_og_image"
                                          label="Gambar Preview Default (Open Graph)"
                                          hint="Dipakai pada halaman tanpa gambar khusus. Ukuran ideal 1200x630px."
                                          :value="$val('seo_default_og_image')" />
                    <x-admin.error name="seo_default_og_image" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="seo_google_site_verification">Google Site Verification</x-admin.label>
                    <x-admin.input id="seo_google_site_verification" name="seo_google_site_verification"
                                   :value="$val('seo_google_site_verification')"
                                   placeholder="Paste kode verifikasi dari Google Search Console" />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Kode dari Search Console. Biarkan kosong jika belum melakukan verifikasi.
                    </p>
                    <x-admin.error name="seo_google_site_verification" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Indeksasi Search Engine">
            <x-admin.checkbox name="seo_allow_indexing"
                              label="Izinkan mesin pencari mengindeks situs"
                              unchecked="0"
                              :value="$checked('seo_allow_indexing')" />

            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                Jika dinonaktifkan, <code class="rounded bg-gray-100 px-1 py-0.5 text-xs dark:bg-white/[0.03]">robots.txt</code>
                akan memakai <code class="rounded bg-gray-100 px-1 py-0.5 text-xs dark:bg-white/[0.03]">Disallow: /</code>
                dan seluruh halaman diberi <code class="rounded bg-gray-100 px-1 py-0.5 text-xs dark:bg-white/[0.03]">noindex</code>.
                Halaman publik juga tidak akan tampil di sitemap.
            </p>
            <x-admin.error name="seo_allow_indexing" />
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Pengaturan</x-admin.button>
            <x-admin.button :href="route('admin.dashboard')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
