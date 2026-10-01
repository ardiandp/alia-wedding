@props([
    'model' => null,
    'title' => null,
    'metaTitle' => null,
    'metaDescription' => null,
    'ogImage' => null,
    'canonicalUrl' => null,
    'entityLabel' => 'halaman',
    'slugBase' => '',
    'titleLimit' => 60,
    'descriptionLimit' => 160,
])

@php
    $siteName = setting('site_name', config('app.name'));
    $currentMetaTitle = old('meta_title', $metaTitle);
    $currentMetaDescription = old('meta_description', $metaDescription);
    $currentCanonical = old('canonical_url', $canonicalUrl);
    $currentOgImage = old('og_image', $ogImage);

    $defaultTitle = \App\Support\Seo::title($title, $currentMetaTitle);
    $defaultDescription = \App\Support\Seo::description($currentMetaDescription, $model?->excerpt);

    $previewUrl = filled($currentCanonical)
        ? \App\Support\Seo::canonical($currentCanonical)
        : ($model?->exists
            ? url($slugBase.'/'.$model->slug)
            : url('/'));

    $fieldConfig = json_encode([
        'titleLimit' => (int) $titleLimit,
        'descriptionLimit' => (int) $descriptionLimit,
        'defaultTitle' => $defaultTitle,
        'defaultDescription' => $defaultDescription,
        'previewUrl' => $previewUrl,
        'metaTitle' => $currentMetaTitle ?? '',
        'metaDescription' => $currentMetaDescription ?? '',
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
@endphp

<div class="space-y-5" x-data="seoFields(@js($fieldConfig))">

    <x-admin.card title="SEO" subtitle="Judul dan deskripsi yang tampil di Google">
        <div class="space-y-5">
            <div>
                <div class="flex items-baseline justify-between gap-3">
                    <x-admin.label for="meta_title">Judul SEO (Meta Title)</x-admin.label>
                    <span class="shrink-0 text-xs"
                          :class="counterClass('title')"
                          x-text="counter('title')"></span>
                </div>

                <x-admin.input id="meta_title"
                               name="meta_title"
                               :value="$currentMetaTitle"
                               x-model="metaTitle"
                               maxlength="255"
                               :placeholder="$title" />

                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    Dikosongkan untuk memakai judul {{ $entityLabel }} sebagai gantinya.
                </p>
                <x-admin.error name="meta_title" />
            </div>

            <div>
                <div class="flex items-baseline justify-between gap-3">
                    <x-admin.label for="meta_description">Deskripsi SEO (Meta Description)</x-admin.label>
                    <span class="shrink-0 text-xs"
                          :class="counterClass('description')"
                          x-text="counter('description')"></span>
                </div>

                <x-admin.textarea id="meta_description"
                                  name="meta_description"
                                  rows="3"
                                  maxlength="500"
                                  x-model="metaDescription"
                                  :placeholder="$model?->excerpt" />

                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    Ringkasan singkat agar pengunjung membuka halaman ini dari hasil pencarian.
                </p>
                <x-admin.error name="meta_description" />
            </div>
        </div>
    </x-admin.card>

    <x-admin.card title="Gambar & URL" subtitle="Gambar preview saat link dibagikan dan URL canonical">
        <div class="space-y-5">
            <x-admin.media-picker name="og_image"
                                  label="Gambar Preview (Open Graph)"
                                  hint="Ukuran ideal 1200x630px."
                                  :value="$currentOgImage" />

            <div>
                <x-admin.label for="canonical_url">URL Canonical</x-admin.label>
                <x-admin.input id="canonical_url"
                               name="canonical_url"
                               type="url"
                               :value="$currentCanonical"
                               :placeholder="$previewUrl" />

                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    Dikosongkan untuk memakai URL halaman ini secara otomatis. Isi hanya jika halaman ini
                    merupakan duplikat dari URL lain.
                </p>
                <x-admin.error name="canonical_url" />
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

        <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
            Google memotong judul sekitar {{ (int) $titleLimit }} karakter dan deskripsi sekitar
            {{ (int) $descriptionLimit }} karakter. Warna hijau berarti panjang ideal, kuning mendekati
            batas, merah terlalu panjang.
        </p>
    </x-admin.card>
</div>