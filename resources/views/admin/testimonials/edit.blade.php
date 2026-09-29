<x-admin-layout title="Edit Testimoni">
    <x-admin.page-header :title="'Edit Testimoni '.$testimonial->customer_name"
                          subtitle="Perbarui isi dan detail testimoni"
                          :back="route('admin.testimonials.index')" />

    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Pemberi Testimoni">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="customer_name" required>Nama Customer</x-admin.label>
                    <x-admin.input id="customer_name" name="customer_name" :value="old('customer_name', $testimonial->customer_name)" required />
                    <x-admin.error name="customer_name" />
                </div>

                <div>
                    <x-admin.label for="partner_name">Nama Pasangan</x-admin.label>
                    <x-admin.input id="partner_name" name="partner_name" :value="old('partner_name', $testimonial->partner_name)" />
                    <x-admin.error name="partner_name" />
                </div>

                <div>
                    <x-admin.label for="photo">Foto</x-admin.label>
                    <x-admin.media-picker name="photo" label="Ganti Foto" :value="$testimonial->photo" />
                    <x-admin.error name="photo" />
                </div>

                <div>
                    <x-admin.label for="rating" required>Rating</x-admin.label>
                    <x-admin.select id="rating" name="rating" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected((int) old('rating', $testimonial->rating) === $i)>{{ $i }} / 5</option>
                        @endfor
                    </x-admin.select>
                    <x-admin.error name="rating" />
                </div>

                <div>
                    <x-admin.label for="wedding_date">Tanggal Pernikahan</x-admin.label>
                    <x-admin.input id="wedding_date" name="wedding_date" type="date"
                                   :value="old('wedding_date', $testimonial->wedding_date?->format('Y-m-d'))" />
                    <x-admin.error name="wedding_date" />
                </div>

                <div>
                    <x-admin.label for="venue_id">Venue</x-admin.label>
                    <x-admin.select id="venue_id" name="venue_id">
                        <option value="">Tanpa venue</option>
                        @foreach ($venues as $venue)
                            <option value="{{ $venue->id }}" @selected(old('venue_id', $testimonial->venue_id) == $venue->id)>
                                {{ $venue->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.error name="venue_id" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="testimonial" required>Testimoni</x-admin.label>
                    <x-admin.textarea id="testimonial" name="testimonial" rows="4"
                                      :value="old('testimonial', $testimonial->testimonial)" required />
                    <x-admin.error name="testimonial" />
                </div>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <x-admin.checkbox name="is_featured" label="Unggulan" :value="old('is_featured', $testimonial->is_featured)" />
                <x-admin.checkbox name="is_active" label="Aktif" :value="old('is_active', $testimonial->is_active)" />
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.testimonials.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
