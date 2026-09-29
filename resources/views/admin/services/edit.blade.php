<x-admin-layout title="Edit Layanan">
    <x-admin.page-header :title="'Edit '.$service->name"
                          subtitle="Perbarui informasi layanan"
                          :back="route('admin.services.index')" />

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Layanan">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" required>Nama Layanan</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name', $service->name)" required />
                    <x-admin.error name="name" />
                </div>

                <div>
                    <x-admin.label for="icon">Ikon</x-admin.label>
                    <x-admin.input id="icon" name="icon" :value="old('icon', $service->icon)" />
                    <x-admin.error name="icon" />
                </div>

                <div>
                    <x-admin.label for="sort_order">Urutan</x-admin.label>
                    <x-admin.input id="sort_order" name="sort_order" type="number"
                                   :value="old('sort_order', $service->sort_order)" min="0" />
                    <x-admin.error name="sort_order" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="image">Gambar</x-admin.label>
                    <x-admin.media-picker name="image" label="Ganti Gambar" :value="$service->image" />
                    <x-admin.error name="image" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="old('description', $service->description)" />
                    <x-admin.error name="description" />
                </div>
            </div>

            <div class="mt-5">
                <x-admin.checkbox name="is_active" label="Aktif" :value="old('is_active', $service->is_active)" />
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.services.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
