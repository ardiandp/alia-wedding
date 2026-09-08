<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Tambah Testimoni') }}</h2>
        @include('admin.partials.admin-nav')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Informasi Pemberi Testimoni</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Customer</label>
                                <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="partner_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pasangan</label>
                                <input id="partner_name" type="text" name="partner_name" value="{{ old('partner_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('partner_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-admin.media-picker name="photo" label="Foto" />
                            </div>

                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                                <select id="rating" name="rating" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" @selected((int) old('rating', 5) === $i)>{{ $i }} / 5</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <div>
                                <label for="wedding_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pernikahan</label>
                                <input id="wedding_date" type="date" name="wedding_date" value="{{ old('wedding_date') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                <x-input-error :messages="$errors->get('wedding_date')" class="mt-2" />
                            </div>

                            <div>
                                <label for="venue_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue</label>
                                <select id="venue_id" name="venue_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                                    <option value="">Tanpa venue</option>
                                    @foreach ($venues as $venue)
                                        <option value="{{ $venue->id }}" @selected(old('venue_id') == $venue->id)>{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('venue_id')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <label for="testimonial" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Testimoni</label>
                                <textarea id="testimonial" name="testimonial" rows="4" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('testimonial') }}</textarea>
                                <x-input-error :messages="$errors->get('testimonial')" class="mt-2" />
                            </div>

                            <div class="flex items-center space-x-6 sm:col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured'))
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Unggulan</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active'))
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.testimonials.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:ring-offset-gray-800">
                            Simpan Testimoni
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>