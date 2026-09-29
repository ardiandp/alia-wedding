<x-admin-layout :title="'Edit '.$package->name">
    <x-admin.page-header :title="'Edit '.$package->name"
                          subtitle="Perbarui detail paket"
                          :back="route('admin.packages.index')" />

    <form method="POST" action="{{ route('admin.packages.update', $package) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Paket">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" required>Nama Paket</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name', $package->name)" required />
                    <x-admin.error name="name" />
                </div>

                <div>
                    <x-admin.label for="venue_id">Venue</x-admin.label>
                    <x-admin.select id="venue_id" name="venue_id">
                        <option value="">Tanpa venue</option>
                        @foreach ($venues as $venue)
                            <option value="{{ $venue->id }}" @selected(old('venue_id', $package->venue_id) == $venue->id)>
                                {{ $venue->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.error name="venue_id" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="old('description', $package->description)" />
                    <x-admin.error name="description" />
                </div>

                <div>
                    <x-admin.label for="price">Harga</x-admin.label>
                    <x-admin.input id="price" name="price" type="number" :value="old('price', $package->price)" step="0.01" min="0" />
                    <x-admin.error name="price" />
                </div>

                <div>
                    <x-admin.label for="price_type" required>Tipe Harga</x-admin.label>
                    <x-admin.select id="price_type" name="price_type" required>
                        <option value="fixed" @selected(old('price_type', $package->price_type) === 'fixed')>Harga Tetap</option>
                        <option value="starting_from" @selected(old('price_type', $package->price_type) === 'starting_from')>Mulai Dari</option>
                        <option value="custom" @selected(old('price_type', $package->price_type) === 'custom')>Custom</option>
                    </x-admin.select>
                    <x-admin.error name="price_type" />
                </div>

                <div>
                    <x-admin.label for="guest_capacity">Kapasitas Tamu</x-admin.label>
                    <x-admin.input id="guest_capacity" name="guest_capacity" type="number"
                                   :value="old('guest_capacity', $package->guest_capacity)" min="1" />
                    <x-admin.error name="guest_capacity" />
                </div>

                <div>
                    <x-admin.label for="image">Gambar Paket</x-admin.label>
                    <x-admin.media-picker name="image" label="Ganti Gambar" :value="$package->image" />
                    <x-admin.error name="image" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="SEO & Publikasi">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="meta_title">Meta Title</x-admin.label>
                    <x-admin.input id="meta_title" name="meta_title" :value="old('meta_title', $package->meta_title)" />
                    <x-admin.error name="meta_title" />
                </div>

                <div>
                    <x-admin.label for="meta_description">Meta Description</x-admin.label>
                    <x-admin.textarea id="meta_description" name="meta_description" rows="3"
                                      :value="old('meta_description', $package->meta_description)" />
                    <x-admin.error name="meta_description" />
                </div>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <x-admin.checkbox name="is_featured" label="Unggulan" :value="old('is_featured', $package->is_featured)" />
                <x-admin.checkbox name="is_active" label="Aktif" :value="old('is_active', $package->is_active)" />
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.packages.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
