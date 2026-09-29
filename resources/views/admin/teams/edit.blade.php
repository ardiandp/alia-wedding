<x-admin-layout title="Edit Anggota Tim">
    <x-admin.page-header :title="'Edit '.$team->name"
                          subtitle="Perbarui informasi anggota tim"
                          :back="route('admin.teams.index')" />

    <form method="POST" action="{{ route('admin.teams.update', $team) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Anggota">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" required>Nama</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name', $team->name)" required />
                    <x-admin.error name="name" />
                </div>

                <div>
                    <x-admin.label for="position" required>Posisi</x-admin.label>
                    <x-admin.input id="position" name="position" :value="old('position', $team->position)" required />
                    <x-admin.error name="position" />
                </div>

                <div>
                    <x-admin.label for="photo">Foto</x-admin.label>
                    <x-admin.media-picker name="photo" label="Ganti Foto" :value="$team->photo" />
                    <x-admin.error name="photo" />
                </div>

                <div>
                    <x-admin.label for="sort_order">Urutan</x-admin.label>
                    <x-admin.input id="sort_order" name="sort_order" type="number"
                                   :value="old('sort_order', $team->sort_order)" min="0" />
                    <x-admin.error name="sort_order" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="old('description', $team->description)" />
                    <x-admin.error name="description" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Media Sosial & Publikasi">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div>
                    <x-admin.label for="instagram">Instagram</x-admin.label>
                    <x-admin.input id="instagram" name="instagram" type="url" :value="old('instagram', $team->instagram)"
                                   placeholder="https://instagram.com/..." />
                    <x-admin.error name="instagram" />
                </div>

                <div>
                    <x-admin.label for="linkedin">LinkedIn</x-admin.label>
                    <x-admin.input id="linkedin" name="linkedin" type="url" :value="old('linkedin', $team->linkedin)"
                                   placeholder="https://linkedin.com/in/..." />
                    <x-admin.error name="linkedin" />
                </div>

                <div>
                    <x-admin.label for="twitter">Twitter / X</x-admin.label>
                    <x-admin.input id="twitter" name="twitter" type="url" :value="old('twitter', $team->twitter)"
                                   placeholder="https://twitter.com/..." />
                    <x-admin.error name="twitter" />
                </div>
            </div>

            <div class="mt-5">
                <x-admin.checkbox name="is_active" label="Aktif" :value="old('is_active', $team->is_active)" />
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.teams.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
