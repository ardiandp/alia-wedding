@php
    $content = $content ?? collect();
    $sections = ['hero', 'intro', 'stats', 'promotion', 'contact_cta'];
    $cv = function ($field) use ($content, $sections) {
        if (old($field) !== null) {
            return old($field);
        }
        if ($content->get($field) !== null) {
            return $content->get($field);
        }
        foreach ($sections as $section) {
            if (str_starts_with($field, $section . '_')) {
                $key = substr($field, strlen($section) + 1);
                $value = $content->get($section . '.' . $key) ?? $content->get($section . '_' . $key);
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
        }
        return '';
    };
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Halaman Beranda') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.homepage.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Bagian Hero</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="hero_heading" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Utama</label>
                                <input id="hero_heading" type="text" name="hero_heading" value="{{ $cv('hero_heading') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('hero_heading')" class="mt-2" />
                            </div>

                            <div>
                                <x-admin.media-picker name="hero_image" label="Ganti Gambar Hero" :value="$cv('hero_image')" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="hero_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Hero</label>
                                <textarea id="hero_description" name="hero_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $cv('hero_description') }}</textarea>
                                <x-input-error :messages="$errors->get('hero_description')" class="mt-2" />
                            </div>

                            <div>
                                <label for="hero_cta_primary_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tombol Utama — Teks</label>
                                <input id="hero_cta_primary_text" type="text" name="hero_cta_primary_text" value="{{ $cv('hero_cta_primary_text') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="hero_cta_primary_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tombol Utama — URL</label>
                                <input id="hero_cta_primary_url" type="text" name="hero_cta_primary_url" value="{{ $cv('hero_cta_primary_url') }}"
                                       placeholder="/venues"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="hero_cta_secondary_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tombol Sekunder — Teks</label>
                                <input id="hero_cta_secondary_text" type="text" name="hero_cta_secondary_text" value="{{ $cv('hero_cta_secondary_text') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="hero_cta_secondary_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tombol Sekunder — URL</label>
                                <input id="hero_cta_secondary_url" type="text" name="hero_cta_secondary_url" value="{{ $cv('hero_cta_secondary_url') }}"
                                       placeholder="/contact"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Bagian Intro</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="intro_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Intro</label>
                                <input id="intro_title" type="text" name="intro_title" value="{{ $cv('intro_title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <x-admin.media-picker name="intro_image" label="Ganti Gambar Intro" :value="$cv('intro_image')" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="intro_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Intro</label>
                                <textarea id="intro_description" name="intro_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $cv('intro_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Bagian Statistik</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label for="stats_happy_couples" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pasangan Bahagia</label>
                                <input id="stats_happy_couples" type="text" name="stats_happy_couples" value="{{ $cv('stats_happy_couples') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_happy_couples_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Label</label>
                                <input id="stats_happy_couples_label" type="text" name="stats_happy_couples_label" value="{{ $cv('stats_happy_couples_label') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_years_experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Pengalaman</label>
                                <input id="stats_years_experience" type="text" name="stats_years_experience" value="{{ $cv('stats_years_experience') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_years_experience_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Label</label>
                                <input id="stats_years_experience_label" type="text" name="stats_years_experience_label" value="{{ $cv('stats_years_experience_label') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_events_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Acara per Tahun</label>
                                <input id="stats_events_year" type="text" name="stats_events_year" value="{{ $cv('stats_events_year') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_events_year_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Label</label>
                                <input id="stats_events_year_label" type="text" name="stats_events_year_label" value="{{ $cv('stats_events_year_label') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_professional_vendors" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vendor Profesional</label>
                                <input id="stats_professional_vendors" type="text" name="stats_professional_vendors" value="{{ $cv('stats_professional_vendors') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                            <div>
                                <label for="stats_professional_vendors_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Label</label>
                                <input id="stats_professional_vendors_label" type="text" name="stats_professional_vendors_label" value="{{ $cv('stats_professional_vendors_label') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Bagian Promosi</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="promotion_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Promosi</label>
                                <input id="promotion_title" type="text" name="promotion_title" value="{{ $cv('promotion_title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="promotion_cta_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Tombol</label>
                                <input id="promotion_cta_text" type="text" name="promotion_cta_text" value="{{ $cv('promotion_cta_text') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="promotion_cta_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Tombol</label>
                                <input id="promotion_cta_url" type="text" name="promotion_cta_url" value="{{ $cv('promotion_cta_url') }}"
                                       placeholder="/packages"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="promotion_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Promosi</label>
                                <textarea id="promotion_description" name="promotion_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $cv('promotion_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Bagian CTA Kontak</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="contact_cta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul CTA</label>
                                <input id="contact_cta_title" type="text" name="contact_cta_title" value="{{ $cv('contact_cta_title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div>
                                <label for="contact_cta_cta_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Tombol</label>
                                <input id="contact_cta_cta_text" type="text" name="contact_cta_cta_text" value="{{ $cv('contact_cta_cta_text') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="contact_cta_cta_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Tombol</label>
                                <input id="contact_cta_cta_url" type="text" name="contact_cta_cta_url" value="{{ $cv('contact_cta_cta_url') }}"
                                       placeholder="/contact"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>