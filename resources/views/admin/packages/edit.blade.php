<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Paket') }} — {{ $package->name }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.packages.update', $package) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Informasi Paket</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Paket</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $package->name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="venue_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue</label>
                                <select id="venue_id" name="venue_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    <option value="">Tanpa venue</option>
                                    @foreach ($venues as $venue)
                                        <option value="{{ $venue->id }}" @selected(old('venue_id', $package->venue_id) == $venue->id)>{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('venue_id')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea id="description" name="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('description', $package->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
                                <input id="price" type="number" name="price" value="{{ old('price', $package->price) }}" step="0.01" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div>
                                <label for="price_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Harga</label>
                                <select id="price_type" name="price_type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    <option value="fixed" @selected(old('price_type', $package->price_type) === 'fixed')>Harga Tetap</option>
                                    <option value="starting_from" @selected(old('price_type', $package->price_type) === 'starting_from')>Mulai Dari</option>
                                    <option value="custom" @selected(old('price_type', $package->price_type) === 'custom')>Custom</option>
                                </select>
                                <x-input-error :messages="$errors->get('price_type')" class="mt-2" />
                            </div>

                            <div>
                                <label for="guest_capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kapasitas Tamu</label>
                                <input id="guest_capacity" type="number" name="guest_capacity" value="{{ old('guest_capacity', $package->guest_capacity) }}" min="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('guest_capacity')" class="mt-2" />
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Gambar Paket</label>
                                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp"
                                       class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-200">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                @if ($package->image)
                                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="mt-3 h-24 rounded-md object-cover">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">SEO & Publikasi</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                <input id="meta_title" type="text" name="meta_title" value="{{ old('meta_title', $package->meta_title) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('meta_description', $package->meta_description) }}</textarea>
                                <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                            </div>

                            <div class="flex items-center space-x-6 sm:col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured))
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Unggulan</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active))
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.packages.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Item Paket</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.packages.items.store', $package) }}"
                          class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-[1fr_auto] sm:items-end">
                        @csrf
                        <div>
                            <label for="item_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Item</label>
                            <input id="item_name" type="text" name="name" required
                                   placeholder="Contoh: Dekorasi pelaminan, Rias pengantin..."
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                            Tambah
                        </button>
                    </form>

                    @if ($package->items->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada item dalam paket ini.</p>
                    @else
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($package->items as $item)
                                <li class="flex items-center justify-between py-3">
                                    <span class="text-sm text-gray-900 dark:text-gray-100">{{ $item->name }}</span>
                                    <form method="POST" action="{{ route('admin.packages.items.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>