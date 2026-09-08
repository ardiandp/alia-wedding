<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Anggota Tim') }} — {{ $team->name }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.teams.update', $team) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Informasi Anggota</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $team->name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Posisi</label>
                                <input id="position" type="text" name="position" value="{{ old('position', $team->position) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Foto</label>
                                <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp"
                                       class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-200">
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                                @if ($team->photo)
                                    <img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}" class="mt-3 h-20 w-20 rounded-full object-cover">
                                @endif
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutan</label>
                                <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $team->sort_order) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea id="description" name="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('description', $team->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Media Sosial & Publikasi</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-3">
                            <div>
                                <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instagram</label>
                                <input id="instagram" type="url" name="instagram" value="{{ old('instagram', $team->instagram) }}" placeholder="https://instagram.com/..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                            </div>

                            <div>
                                <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">LinkedIn</label>
                                <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin', $team->linkedin) }}" placeholder="https://linkedin.com/in/..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                            </div>

                            <div>
                                <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Twitter / X</label>
                                <input id="twitter" type="url" name="twitter" value="{{ old('twitter', $team->twitter) }}" placeholder="https://twitter.com/..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('twitter')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $team->is_active))
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.teams.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
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