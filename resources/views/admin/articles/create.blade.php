<x-admin-layout title="Tambah Artikel">
    <x-admin.page-header title="Tambah Artikel"
                          subtitle="Tulis artikel baru untuk halaman berita"
                          :back="route('admin.articles.index')" />

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf

        <x-admin.card title="Informasi Artikel">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="title" required>Judul Artikel</x-admin.label>
                    <x-admin.input id="title" name="title" :value="old('title')" required />
                    <x-admin.error name="title" />
                </div>

                <div>
                    <x-admin.label for="category">Kategori</x-admin.label>
                    <x-admin.input id="category" name="category" :value="old('category')" />
                    <x-admin.error name="category" />
                </div>

                <div>
                    <x-admin.label for="status" required>Status</x-admin.label>
                    <x-admin.select id="status" name="status" required>
                        <option value="draft" @selected(old('status') === 'draft')>Draf</option>
                        <option value="published" @selected(old('status') === 'published')>Terbit</option>
                    </x-admin.select>
                    <x-admin.error name="status" />
                </div>

                <div>
                    <x-admin.label for="published_at">Tanggal Terbit</x-admin.label>
                    <x-admin.input id="published_at" name="published_at" type="date" :value="old('published_at')" />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Kosongkan untuk otomatis diisi tanggal hari ini saat dipublikasikan.
                    </p>
                    <x-admin.error name="published_at" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="excerpt">Ringkasan</x-admin.label>
                    <x-admin.textarea id="excerpt" name="excerpt" rows="3" :value="old('excerpt')" />
                    <x-admin.error name="excerpt" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="body">Isi Artikel</x-admin.label>
                    <x-admin.textarea id="body" name="body" rows="14" :value="old('body')" />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Pisahkan paragraf dengan baris kosong.</p>
                    <x-admin.error name="body" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="image">Gambar Artikel</x-admin.label>
                    <x-admin.media-picker name="image" label="Gambar Artikel" />
                    <x-admin.error name="image" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.seo-fields :title="old('title')"
                            entity-label="artikel"
                            slug-base="/artikel" />

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Artikel</x-admin.button>
            <x-admin.button :href="route('admin.articles.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
