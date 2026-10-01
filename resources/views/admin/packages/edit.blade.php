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

        <div x-data="{ items: {{ Js::from(old('items', $package->items->pluck('name')->all())) }} }">
            <x-admin.card title="Rincian Paket"
                          subtitle="Fitur dan layanan yang termasuk dalam paket ini">
                <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    Urutan baris sesuai urutan tampil di halaman publik. Baris kosong diabaikan.
                </p>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex items-center gap-3">
                            <x-admin.input name="items[]"
                                           x-model="items[index]"
                                           placeholder="Contoh: Catering (200 pax)" />

                            <button type="button" @click="items.splice(index, 1)"
                                    class="inline-flex shrink-0 items-center rounded-xl border border-red-200 px-3 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-500/40 dark:text-red-400 dark:hover:bg-red-500/10">
                                Hapus
                            </button>
                        </div>
                    </template>

                    <p x-show="items.length === 0" x-cloak
                       class="rounded-xl border border-dashed border-gray-300 px-4 py-6 text-center text-sm text-gray-400 dark:border-gray-700">
                        Belum ada rincian. Tambahkan fitur yang sudah termasuk dalam paket.
                    </p>
                </div>

                <x-admin.button type="button" variant="secondary" icon="plus" class="mt-4"
                                @click="items.push('')">Tambah Rincian</x-admin.button>

                @php
                    $itemErrors = collect($errors->keys())
                        ->filter(fn ($key) => $key === 'items' || str_starts_with($key, 'items.'))
                        ->flatMap(fn ($key) => $errors->get($key))
                        ->unique();
                @endphp
                @foreach ($itemErrors as $itemError)
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $itemError }}</p>
                @endforeach
            </x-admin.card>
        </div>

        <x-admin.card title="Publikasi">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <x-admin.checkbox name="is_featured" label="Paket Unggulan" unchecked="0"
                                  :value="old('is_featured', $package->is_featured)" />
                <x-admin.checkbox name="is_active" label="Tampilkan di Website" unchecked="0"
                                  :value="old('is_active', $package->is_active)" />
            </div>
        </x-admin.card>

        <x-admin.seo-fields :model="$package"
                            :title="$package->name"
                            entity-label="paket"
                            slug-base="/packages" />

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.packages.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
