@php
    $missions = old('missions', $about?->missions ?? []);
    $old = fn ($key) => old($key, $about?->$key ?? '');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Halaman Tentang') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Konten Utama</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                                <input id="title" type="text" name="title" value="{{ $old('title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Gambar</label>
                                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp"
                                       class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-200">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                @if ($about?->image)
                                    <img src="{{ asset('storage/' . $about->image) }}" alt="Gambar tentang" class="mt-3 h-28 w-full rounded-md object-cover">
                                @endif
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea id="description" name="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="company_history" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Riwayat Perusahaan</label>
                                <textarea id="company_history" name="company_history" rows="5"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $old('company_history') }}</textarea>
                                <x-input-error :messages="$errors->get('company_history')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="vision" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visi</label>
                                <textarea id="vision" name="vision" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ $old('vision') }}</textarea>
                                <x-input-error :messages="$errors->get('vision')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Misi Perusahaan</h3>
                        </div>
                        <div class="p-6">
                            <div x-data="{ missions: {{ Js::from($missions) }} }">
                                <div class="space-y-3">
                                    <template x-for="(mission, index) in missions" :key="index">
                                        <div class="flex items-center gap-3">
                                            <input type="text" name="missions[]" x-model="missions[index]"
                                                   placeholder="Tulis misi perusahaan..."
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                            <button type="button" @click="missions.splice(index, 1)"
                                                    class="inline-flex shrink-0 items-center rounded-md border border-red-200 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20">
                                                Hapus
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="missions.push('')"
                                        class="mt-4 inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Tambah Misi
                                </button>
                                <x-input-error :messages="$errors->get('missions')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>