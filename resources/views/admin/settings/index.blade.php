@php
    $val = fn ($key) => old($key, is_array($settings) ? ($settings[$key] ?? '') : ($settings->get($key, '') ?? ''));
    $checked = fn ($key) => (bool) old($key, is_array($settings) ? ($settings[$key] ?? false) : ($settings->get($key) ?? false));
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Pengaturan Website') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Informasi Umum</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Situs</label>
                                <input id="site_name" type="text" name="site_name" value="{{ $val('site_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="site_tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tagline</label>
                                <input id="site_tagline" type="text" name="site_tagline" value="{{ $val('site_tagline') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Situs</label>
                                <textarea id="site_description" name="site_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $val('site_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Kontak & WhatsApp</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Kontak</label>
                                <input id="contact_email" type="email" name="contact_email" value="{{ $val('contact_email') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon Kontak</label>
                                <input id="contact_phone" type="text" name="contact_phone" value="{{ $val('contact_phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WhatsApp</label>
                                <input id="whatsapp_number" type="text" name="whatsapp_number" value="{{ $val('whatsapp_number') }}"
                                       placeholder="6281234567890"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="whatsapp_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesan WhatsApp Default</label>
                                <input id="whatsapp_message" type="text" name="whatsapp_message" value="{{ $val('whatsapp_message') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div class="sm:col-span-2 flex items-center">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="whatsapp_floating_enabled" value="1" @checked($checked('whatsapp_floating_enabled'))
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Tombol WhatsApp Mengambang</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Media Sosial</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instagram</label>
                                <input id="instagram_url" type="url" name="instagram_url" value="{{ $val('instagram_url') }}"
                                       placeholder="https://instagram.com/..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook</label>
                                <input id="facebook_url" type="url" name="facebook_url" value="{{ $val('facebook_url') }}"
                                       placeholder="https://facebook.com/..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="tiktok_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">TikTok</label>
                                <input id="tiktok_url" type="url" name="tiktok_url" value="{{ $val('tiktok_url') }}"
                                       placeholder="https://tiktok.com/@..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube</label>
                                <input id="youtube_url" type="url" name="youtube_url" value="{{ $val('youtube_url') }}"
                                       placeholder="https://youtube.com/@..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Lokasi</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                                <input id="address" type="text" name="address" value="{{ $val('address') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="google_maps_embed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Google Maps Embed URL</label>
                                <input id="google_maps_embed" type="url" name="google_maps_embed" value="{{ $val('google_maps_embed') }}"
                                       placeholder="https://www.google.com/maps/embed?pb=..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="operational_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam Operasional</label>
                                <input id="operational_hours" type="text" name="operational_hours" value="{{ $val('operational_hours') }}"
                                       placeholder="Senin – Minggu: 09.00 – 21.00"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">SEO Default</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="seo_default_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul SEO Default</label>
                                <input id="seo_default_title" type="text" name="seo_default_title" value="{{ $val('seo_default_title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="seo_default_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi SEO Default</label>
                                <textarea id="seo_default_description" name="seo_default_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $val('seo_default_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                            Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>