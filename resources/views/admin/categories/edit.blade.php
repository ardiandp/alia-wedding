<x-admin-layout title="Edit Kategori">
    <x-admin.page-header :title="'Edit '.$category->name"
                          subtitle="Perbarui detail kategori"
                          :back="route('admin.categories.index')" />

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="max-w-3xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Kategori">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" required>Nama Kategori</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name', $category->name)" required />
                    <x-admin.error name="name" />
                </div>

                <div>
                    <x-admin.label for="sort_order">Urutan</x-admin.label>
                    <x-admin.input id="sort_order" name="sort_order" type="number" :value="old('sort_order', $category->sort_order)" min="0" />
                    <x-admin.error name="sort_order" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="old('description', $category->description)" />
                    <x-admin.error name="description" />
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.categories.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
