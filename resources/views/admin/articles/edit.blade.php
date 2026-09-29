<x-admin-layout title="Edit Artikel">
    <x-admin.page-header :title="'Edit '.$article->title"
                          subtitle="Perbarui isi dan metadata artikel"
                          :back="route('admin.articles.index')" />

    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Artikel">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="title" required>Judul Artikel</x-admin.label>
                    <x-admin.input id="title" name="title" :value="old('title', $article->title)" required />
                    <x-admin.error name="title" />
                </div>

                <div>
                    <x-admin.label for="category">Kategori</x-admin.label>
                    <x-admin.input id="category" name="category" :value="old('category', $article->category)" />
                    <x-admin.error name="category" />
                </div>

                <div>
                    <x-admin.label for="status" required>Status</x-admin.label>
                    <x-admin.select id="status" name="status" required>
                        <option value="draft" @selected(old('status', $article->status) === 'draft')>Draf</option>
                        <option value="published" @selected(old('status', $article->status) === 'published')>Terbit</option>
                    </x-admin.select>
                    <x-admin.error name="status" />
                </div>

                <div>
                    <x-admin.label for="published_at">Tanggal Terbit</x-admin.label>
                    <x-admin.input id="published_at" name="published_at" type="date"
                                   :value="old('published_at', $article->published_at?->format('Y-m-d'))" />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Kosongkan agar tetap mempertahankan tanggal terbit saat ini.
                    </p>
                    <x-admin.error name="published_at" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="excerpt">Ringkasan</x-admin.label>
                    <x-admin.textarea id="excerpt" name="excerpt" rows="3" :value="old('excerpt', $article->excerpt)" />
                    <x-admin.error name="excerpt" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="body">Isi Artikel</x-admin.label>
                    <x-admin.textarea id="body" name="body" rows="14" :value="old('body', $article->body)" />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Pisahkan paragraf dengan baris kosong.</p>
                    <x-admin.error name="body" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="image">Gambar Artikel</x-admin.label>
                    <x-admin.media-picker name="image" label="Ganti Gambar" :value="$article->image" />
                    <x-admin.error name="image" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="SEO">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="meta_title">Meta Title</x-admin.label>
                    <x-admin.input id="meta_title" name="meta_title" :value="old('meta_title', $article->meta_title)" />
                    <x-admin.error name="meta_title" />
                </div>

                <div>
                    <x-admin.label for="meta_description">Meta Description</x-admin.label>
                    <x-admin.textarea id="meta_description" name="meta_description" rows="3"
                                      :value="old('meta_description', $article->meta_description)" />
                    <x-admin.error name="meta_description" />
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.articles.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
