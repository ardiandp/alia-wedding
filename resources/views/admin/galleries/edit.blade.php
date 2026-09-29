@php
    use App\Models\Gallery;

    $categories = $categories ?? Gallery::CATEGORIES;
@endphp

<x-admin-layout title="Edit Galeri">
    <x-admin.page-header :title="'Edit '.$gallery->title"
                          subtitle="Perbarui detail foto galeri"
                          :back="route('admin.galleries.index')" />

    <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Galeri">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="title" required>Judul</x-admin.label>
                    <x-admin.input id="title" name="title" :value="old('title', $gallery->title)" required />
                    <x-admin.error name="title" />
                </div>

                <div>
                    <x-admin.label for="category" required>Kategori</x-admin.label>
                    <x-admin.select id="category" name="category" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(old('category', $gallery->category) === $category)>
                                {{ Str::title(str_replace('_', ' ', $category)) }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.error name="category" />
                </div>

                <div>
                    <x-admin.label for="image">Gambar</x-admin.label>
                    <x-admin.media-picker name="image" label="Ganti Gambar" :value="$gallery->image" />
                    <x-admin.error name="image" />
                </div>

                <div>
                    <x-admin.label for="sort_order">Urutan</x-admin.label>
                    <x-admin.input id="sort_order" name="sort_order" type="number"
                                   :value="old('sort_order', $gallery->sort_order)" min="0" />
                    <x-admin.error name="sort_order" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="3" :value="old('description', $gallery->description)" />
                    <x-admin.error name="description" />
                </div>
            </div>

            <div class="mt-5">
                <x-admin.checkbox name="is_active" label="Aktif" :value="old('is_active', $gallery->is_active)" />
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.galleries.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
