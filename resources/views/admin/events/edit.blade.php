<x-admin-layout :title="'Edit '.$event->title">
    <x-admin.page-header :title="'Edit '.$event->title"
                          subtitle="Perbarui detail agenda"
                          :back="route('admin.events.index')" />

    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="max-w-5xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Agenda">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="title" required>Judul Agenda</x-admin.label>
                    <x-admin.input id="title" name="title" :value="old('title', $event->title)" required />
                    <x-admin.error name="title" />
                </div>

                <div>
                    <x-admin.label for="event_type" required>Tipe Agenda</x-admin.label>
                    <x-admin.select id="event_type" name="event_type" required>
                        <option value="wedding" @selected(old('event_type', $event->event_type) === 'wedding')>Pernikahan</option>
                        <option value="open_house" @selected(old('event_type', $event->event_type) === 'open_house')>Open House</option>
                        <option value="expo" @selected(old('event_type', $event->event_type) === 'expo')>Expo</option>
                        <option value="venue_tour" @selected(old('event_type', $event->event_type) === 'venue_tour')>Tur Venue</option>
                        <option value="food_testing" @selected(old('event_type', $event->event_type) === 'food_testing')>Food Testing</option>
                        <option value="promotion" @selected(old('event_type', $event->event_type) === 'promotion')>Promosi</option>
                    </x-admin.select>
                    <x-admin.error name="event_type" />
                </div>

                <div>
                    <x-admin.label for="venue_id">Venue</x-admin.label>
                    <x-admin.select id="venue_id" name="venue_id">
                        <option value="">Tanpa venue</option>
                        @foreach ($venues as $venue)
                            <option value="{{ $venue->id }}" @selected(old('venue_id', $event->venue_id) == $venue->id)>
                                {{ $venue->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                    <x-admin.error name="venue_id" />
                </div>

                <div>
                    <x-admin.label for="status" required>Status</x-admin.label>
                    <x-admin.select id="status" name="status" required>
                        <option value="draft" @selected(old('status', $event->status) === 'draft')>Draf</option>
                        <option value="published" @selected(old('status', $event->status) === 'published')>Terbit</option>
                        <option value="completed" @selected(old('status', $event->status) === 'completed')>Selesai</option>
                        <option value="cancelled" @selected(old('status', $event->status) === 'cancelled')>Dibatalkan</option>
                    </x-admin.select>
                    <x-admin.error name="status" />
                </div>

                <div class="sm:col-span-2">
                    <x-admin.label for="description">Deskripsi</x-admin.label>
                    <x-admin.textarea id="description" name="description" rows="4" :value="old('description', $event->description)" />
                    <x-admin.error name="description" />
                </div>

                <div>
                    <x-admin.label for="start_date" required>Tanggal Mulai</x-admin.label>
                    <x-admin.input id="start_date" name="start_date" type="date"
                                   :value="old('start_date', $event->start_date?->format('Y-m-d'))" required />
                    <x-admin.error name="start_date" />
                </div>

                <div>
                    <x-admin.label for="end_date">Tanggal Selesai</x-admin.label>
                    <x-admin.input id="end_date" name="end_date" type="date"
                                   :value="old('end_date', $event->end_date?->format('Y-m-d'))" />
                    <x-admin.error name="end_date" />
                </div>

                <div>
                    <x-admin.label for="start_time">Jam Mulai</x-admin.label>
                    <x-admin.input id="start_time" name="start_time" type="time" :value="old('start_time')" />
                    <x-admin.error name="start_time" />
                </div>

                <div>
                    <x-admin.label for="end_time">Jam Selesai</x-admin.label>
                    <x-admin.input id="end_time" name="end_time" type="time" :value="old('end_time')" />
                    <x-admin.error name="end_time" />
                </div>

                <div>
                    <x-admin.label for="image">Gambar Agenda</x-admin.label>
                    <x-admin.media-picker name="image" label="Ganti Gambar" :value="$event->image" />
                    <x-admin.error name="image" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="SEO">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="meta_title">Meta Title</x-admin.label>
                    <x-admin.input id="meta_title" name="meta_title" :value="old('meta_title', $event->meta_title)" />
                    <x-admin.error name="meta_title" />
                </div>

                <div>
                    <x-admin.label for="meta_description">Meta Description</x-admin.label>
                    <x-admin.textarea id="meta_description" name="meta_description" rows="3"
                                      :value="old('meta_description', $event->meta_description)" />
                    <x-admin.error name="meta_description" />
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.events.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
