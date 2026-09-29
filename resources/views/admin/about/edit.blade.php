@php
    $missions = old('missions', $about?->missions ?? []);
    $old = fn ($key) => old($key, $about?->$key ?? '');
@endphp

<x-admin-layout title="Tentang">
    <x-admin.page-header title="Edit Halaman Tentang"
                          subtitle="Kelola konten halaman profil dan sejarah perusahaan"
                          :back="route('admin.dashboard')" />

    <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Konten Utama">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-admin.label for="title">Judul</x-admin.label>
                    <x-admin.input id="title" name="title" :value="$old('title')" />
                    <x-admin.error name="title" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="image">Gambar</x-admin.label>
                    <x-admin.media-picker name="image" label="Ganti Gambar" :value="$about?->image" />
                    <x-admin.error name="image" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="$old('description')" />
                    <x-admin.error name="description" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="company_history">Riwayat Perusahaan</x-admin.label>
                    <x-admin.textarea id="company_history" name="company_history" rows="5" :value="$old('company_history')" />
                    <x-admin.error name="company_history" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="vision">Visi</x-admin.label>
                    <x-admin.textarea id="vision" name="vision" rows="3" :value="$old('vision')" />
                    <x-admin.error name="vision" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Misi Perusahaan">
            <div x-data="{ missions: {{ Js::from($missions) }} }">
                <div class="space-y-3">
                    <template x-for="(mission, index) in missions" :key="index">
                        <div class="flex items-center gap-3">
                            <input type="text" name="missions[]" x-model="missions[index]"
                                   placeholder="Tulis misi perusahaan..."
                                   class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white dark:placeholder:text-gray-500">

                            <button type="button" @click="missions.splice(index, 1)"
                                    class="inline-flex shrink-0 items-center rounded-xl border border-red-200 px-3 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-500/40 dark:text-red-400 dark:hover:bg-red-500/10">
                                Hapus
                            </button>
                        </div>
                    </template>
                </div>

                <x-admin.button type="button" variant="secondary" icon="plus" class="mt-4"
                                @click="missions.push('')">Tambah Misi</x-admin.button>

                <x-admin.error name="missions" />
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.dashboard')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
