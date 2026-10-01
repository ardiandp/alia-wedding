<x-admin-layout :title="'Edit '.$venue->name">
    <x-admin.page-header :title="'Edit '.$venue->name"
                          subtitle="Perbarui detail venue"
                          :back="route('admin.venues.index')" />

    <form method="POST" action="{{ route('admin.venues.update', $venue) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Dasar">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-admin.label for="name" required>Nama Venue</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name', $venue->name)" required />
                    <x-admin.error name="name" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="old('description', $venue->description)" />
                    <x-admin.error name="description" />
                </div>

                <div>
                    <x-admin.label for="capacity">Kapasitas</x-admin.label>
                    <x-admin.input id="capacity" name="capacity" type="number" :value="old('capacity', $venue->capacity)" min="1" />
                    <x-admin.error name="capacity" />
                </div>

                <div>
                    <x-admin.label for="size">Luas (m&sup2;)</x-admin.label>
                    <x-admin.input id="size" name="size" type="number" :value="old('size', $venue->size)" min="1" />
                    <x-admin.error name="size" />
                </div>

                <div>
                    <x-admin.label for="type" required>Tipe Venue</x-admin.label>
                    <x-admin.select id="type" name="type" required>
                        <option value="indoor" @selected(old('type', $venue->type) === 'indoor')>Indoor</option>
                        <option value="outdoor" @selected(old('type', $venue->type) === 'outdoor')>Outdoor</option>
                        <option value="indoor_outdoor" @selected(old('type', $venue->type) === 'indoor_outdoor')>Indoor &amp; Outdoor</option>
                    </x-admin.select>
                    <x-admin.error name="type" />
                </div>

                <div>
                    <x-admin.label for="starting_price">Harga Mulai Dari</x-admin.label>
                    <x-admin.input id="starting_price" name="starting_price" type="number"
                                   :value="old('starting_price', $venue->starting_price)" step="0.01" min="0" />
                    <x-admin.error name="starting_price" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="virtual_tour_url">URL Virtual Tour</x-admin.label>
                    <x-admin.input id="virtual_tour_url" name="virtual_tour_url" type="url"
                                   :value="old('virtual_tour_url', $venue->virtual_tour_url)" placeholder="https://..." />
                    <x-admin.error name="virtual_tour_url" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Media & Lokasi">
            @if ($venue->hero_image || $venue->floor_plan)
                <div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @if ($venue->hero_image)
                        <div>
                            <img src="{{ asset('storage/'.$venue->hero_image) }}" alt="Foto utama"
                                 class="h-32 w-full rounded-xl object-cover">
                            <p class="mt-2 text-xs font-medium text-gray-500 dark:text-gray-400">Foto Utama</p>
                        </div>
                    @endif
                    @if ($venue->floor_plan)
                        <div>
                            <img src="{{ asset('storage/'.$venue->floor_plan) }}" alt="Denah lantai"
                                 class="h-32 w-full rounded-xl border border-gray-200 object-contain dark:border-gray-700">
                            <p class="mt-2 text-xs font-medium text-gray-500 dark:text-gray-400">Denah Lantai</p>
                        </div>
                    @endif
                </div>

                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">Unggah file baru di bawah untuk mengganti.</p>
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="hero_image">Ganti Foto Utama</x-admin.label>
                    <x-admin.media-picker name="hero_image" label="Ganti Foto Utama" :value="$venue->hero_image" />
                    <x-admin.error name="hero_image" />
                </div>

                <div>
                    <x-admin.label for="floor_plan">Ganti Denah Lantai</x-admin.label>
                    <x-admin.file id="floor_plan" name="floor_plan"
                                  accept="image/jpeg,image/png,image/webp,application/pdf"
                                  hint="Format JPG, PNG, WEBP, atau PDF dengan maksimal 5 MB." />
                    <x-admin.error name="floor_plan" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="address">Alamat</x-admin.label>
                    <x-admin.input id="address" name="address" :value="old('address', $venue->address)" />
                    <x-admin.error name="address" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="google_maps_embed">Google Maps Embed URL</x-admin.label>
                    <x-admin.input id="google_maps_embed" name="google_maps_embed" type="url"
                                   :value="old('google_maps_embed', $venue->google_maps_embed)"
                                   placeholder="https://www.google.com/maps/embed?pb=..." />
                    <x-admin.error name="google_maps_embed" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Fasilitas & Layanan">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div>
                    <x-admin.label for="parking">Parkir</x-admin.label>
                    <x-admin.input id="parking" name="parking" :value="old('parking', $venue->parking)" />
                    <x-admin.error name="parking" />
                </div>

                <div>
                    <x-admin.label for="catering">Katering</x-admin.label>
                    <x-admin.input id="catering" name="catering" :value="old('catering', $venue->catering)" />
                    <x-admin.error name="catering" />
                </div>

                <div>
                    <x-admin.label for="decoration">Dekorasi</x-admin.label>
                    <x-admin.input id="decoration" name="decoration" :value="old('decoration', $venue->decoration)" />
                    <x-admin.error name="decoration" />
                </div>

                <div class="sm:col-span-3">
                    <x-admin.label for="facility_note">Catatan Fasilitas</x-admin.label>
                    <x-admin.textarea id="facility_note" name="facility_note" rows="3"
                                      :value="old('facility_note', $venue->facility_note)" />
                    <x-admin.error name="facility_note" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Publikasi">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <x-admin.checkbox name="is_featured" label="Venue Unggulan" unchecked="0"
                                  :value="old('is_featured', $venue->is_featured)" />
                <x-admin.checkbox name="is_active" label="Tampilkan di Website" unchecked="0"
                                  :value="old('is_active', $venue->is_active)" />
            </div>
        </x-admin.card>

        <x-admin.seo-fields :model="$venue"
                            :title="$venue->name"
                            entity-label="venue"
                            slug-base="/venues" />

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.venues.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
