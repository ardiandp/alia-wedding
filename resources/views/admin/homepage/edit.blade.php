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
            if (str_starts_with($field, $section.'_')) {
                $key = substr($field, strlen($section) + 1);
                $value = $content->get($section.'.'.$key) ?? $content->get($section.'_'.$key);
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
        }

        return '';
    };
@endphp

<x-admin-layout title="Edit Halaman Beranda">
    <x-admin.page-header title="Edit Halaman Beranda"
                          subtitle="Kelola konten yang tampil di halaman depan"
                          :back="route('admin.dashboard')" />

    <form method="POST" action="{{ route('admin.homepage.update') }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Bagian Hero">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="hero_heading">Judul Utama</x-admin.label>
                    <x-admin.input id="hero_heading" name="hero_heading" :value="$cv('hero_heading')" />
                    <x-admin.error name="hero_heading" />
                </div>

                <div>
                    <x-admin.label for="hero_image">Gambar Hero</x-admin.label>
                    <x-admin.media-picker name="hero_image" label="Ganti Gambar Hero" :value="$cv('hero_image')" />
                    <x-admin.error name="hero_image" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="hero_description">Deskripsi Hero</x-admin.label>
                    <x-admin.textarea id="hero_description" name="hero_description" rows="3" :value="$cv('hero_description')" />
                    <x-admin.error name="hero_description" />
                </div>

                <div>
                    <x-admin.label for="hero_cta_primary_text">Tombol Utama &mdash; Teks</x-admin.label>
                    <x-admin.input id="hero_cta_primary_text" name="hero_cta_primary_text" :value="$cv('hero_cta_primary_text')" />
                    <x-admin.error name="hero_cta_primary_text" />
                </div>

                <div>
                    <x-admin.label for="hero_cta_primary_url">Tombol Utama &mdash; URL</x-admin.label>
                    <x-admin.input id="hero_cta_primary_url" name="hero_cta_primary_url"
                                   :value="$cv('hero_cta_primary_url')" placeholder="/venues" />
                    <x-admin.error name="hero_cta_primary_url" />
                </div>

                <div>
                    <x-admin.label for="hero_cta_secondary_text">Tombol Sekunder &mdash; Teks</x-admin.label>
                    <x-admin.input id="hero_cta_secondary_text" name="hero_cta_secondary_text" :value="$cv('hero_cta_secondary_text')" />
                    <x-admin.error name="hero_cta_secondary_text" />
                </div>

                <div>
                    <x-admin.label for="hero_cta_secondary_url">Tombol Sekunder &mdash; URL</x-admin.label>
                    <x-admin.input id="hero_cta_secondary_url" name="hero_cta_secondary_url"
                                   :value="$cv('hero_cta_secondary_url')" placeholder="/contact" />
                    <x-admin.error name="hero_cta_secondary_url" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Bagian Intro">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="intro_title">Judul Intro</x-admin.label>
                    <x-admin.input id="intro_title" name="intro_title" :value="$cv('intro_title')" />
                    <x-admin.error name="intro_title" />
                </div>

                <div>
                    <x-admin.label for="intro_image">Gambar Intro</x-admin.label>
                    <x-admin.media-picker name="intro_image" label="Ganti Gambar Intro" :value="$cv('intro_image')" />
                    <x-admin.error name="intro_image" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="intro_description">Deskripsi Intro</x-admin.label>
                    <x-admin.textarea id="intro_description" name="intro_description" rows="3" :value="$cv('intro_description')" />
                    <x-admin.error name="intro_description" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Bagian Statistik">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <x-admin.label for="stats_happy_couples">Pasangan Bahagia</x-admin.label>
                    <x-admin.input id="stats_happy_couples" name="stats_happy_couples" :value="$cv('stats_happy_couples')" />
                    <x-admin.error name="stats_happy_couples" />
                </div>

                <div>
                    <x-admin.label for="stats_happy_couples_label">Label</x-admin.label>
                    <x-admin.input id="stats_happy_couples_label" name="stats_happy_couples_label" :value="$cv('stats_happy_couples_label')" />
                    <x-admin.error name="stats_happy_couples_label" />
                </div>

                <div>
                    <x-admin.label for="stats_years_experience">Tahun Pengalaman</x-admin.label>
                    <x-admin.input id="stats_years_experience" name="stats_years_experience" :value="$cv('stats_years_experience')" />
                    <x-admin.error name="stats_years_experience" />
                </div>

                <div>
                    <x-admin.label for="stats_years_experience_label">Label</x-admin.label>
                    <x-admin.input id="stats_years_experience_label" name="stats_years_experience_label" :value="$cv('stats_years_experience_label')" />
                    <x-admin.error name="stats_years_experience_label" />
                </div>

                <div>
                    <x-admin.label for="stats_events_year">Acara per Tahun</x-admin.label>
                    <x-admin.input id="stats_events_year" name="stats_events_year" :value="$cv('stats_events_year')" />
                    <x-admin.error name="stats_events_year" />
                </div>

                <div>
                    <x-admin.label for="stats_events_year_label">Label</x-admin.label>
                    <x-admin.input id="stats_events_year_label" name="stats_events_year_label" :value="$cv('stats_events_year_label')" />
                    <x-admin.error name="stats_events_year_label" />
                </div>

                <div>
                    <x-admin.label for="stats_professional_vendors">Vendor Profesional</x-admin.label>
                    <x-admin.input id="stats_professional_vendors" name="stats_professional_vendors" :value="$cv('stats_professional_vendors')" />
                    <x-admin.error name="stats_professional_vendors" />
                </div>

                <div>
                    <x-admin.label for="stats_professional_vendors_label">Label</x-admin.label>
                    <x-admin.input id="stats_professional_vendors_label" name="stats_professional_vendors_label" :value="$cv('stats_professional_vendors_label')" />
                    <x-admin.error name="stats_professional_vendors_label" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Bagian Promosi">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="promotion_title">Judul Promosi</x-admin.label>
                    <x-admin.input id="promotion_title" name="promotion_title" :value="$cv('promotion_title')" />
                    <x-admin.error name="promotion_title" />
                </div>

                <div>
                    <x-admin.label for="promotion_cta_text">Teks Tombol</x-admin.label>
                    <x-admin.input id="promotion_cta_text" name="promotion_cta_text" :value="$cv('promotion_cta_text')" />
                    <x-admin.error name="promotion_cta_text" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="promotion_cta_url">URL Tombol</x-admin.label>
                    <x-admin.input id="promotion_cta_url" name="promotion_cta_url"
                                   :value="$cv('promotion_cta_url')" placeholder="/packages" />
                    <x-admin.error name="promotion_cta_url" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="promotion_description">Deskripsi Promosi</x-admin.label>
                    <x-admin.textarea id="promotion_description" name="promotion_description" rows="3" :value="$cv('promotion_description')" />
                    <x-admin.error name="promotion_description" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Bagian CTA Kontak">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="contact_cta_title">Judul CTA</x-admin.label>
                    <x-admin.input id="contact_cta_title" name="contact_cta_title" :value="$cv('contact_cta_title')" />
                    <x-admin.error name="contact_cta_title" />
                </div>

                <div>
                    <x-admin.label for="contact_cta_cta_text">Teks Tombol</x-admin.label>
                    <x-admin.input id="contact_cta_cta_text" name="contact_cta_cta_text" :value="$cv('contact_cta_cta_text')" />
                    <x-admin.error name="contact_cta_cta_text" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="contact_cta_cta_url">URL Tombol</x-admin.label>
                    <x-admin.input id="contact_cta_cta_url" name="contact_cta_cta_url"
                                   :value="$cv('contact_cta_cta_url')" placeholder="/contact" />
                    <x-admin.error name="contact_cta_cta_url" />
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.dashboard')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
