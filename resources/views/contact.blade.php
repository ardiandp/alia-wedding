<x-layouts.public :meta-title="'Kontak & Konsultasi | '.setting('site_name')">
    <section class="bg-white border-b border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 text-center">Kontak & Konsultasi</h1>
            <p class="mt-4 text-gray-600 text-center max-w-2xl mx-auto">Konsultasikan rencana pernikahan Anda, wedding consultant kami siap membantu</p>
        </div>
    </section>

    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- Contact info --}}
                <aside class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h2 class="font-display text-xl font-bold text-gray-900 mb-4">Informasi Kontak</h2>
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-gray-600">{{ setting('address', '-') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span class="text-gray-600">{{ setting('contact_phone', '-') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span class="text-gray-600">{{ setting('contact_email', '-') }}</span>
                            </li>
                        </ul>
                    </div>
                    @if(setting('google_maps_embed'))
                        <div class="rounded-xl overflow-hidden">
                            <iframe src="{{ setting('google_maps_embed') }}" class="w-full h-64" style="border:0" loading="lazy" allowfullscreen></iframe>
                        </div>
                    @endif
                </aside>

                {{-- Form --}}
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('contact.store') }}" class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 sm:p-8">
                        @csrf
                        <h2 class="font-display text-2xl font-bold text-gray-900 mb-6">Form Konsultasi</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-rose-600">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500" required>
                                @error('full_name')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Pasangan</label>
                                <input type="text" name="partner_name" value="{{ old('partner_name') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-rose-600">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500" required>
                                @error('email')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp <span class="text-rose-600">*</span></label>
                                <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500" required>
                                @error('whatsapp')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Pernikahan</label>
                                <input type="date" name="wedding_date" value="{{ old('wedding_date') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                                @error('wedding_date')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Estimasi Tamu</label>
                                <input type="number" name="estimated_guests" value="{{ old('estimated_guests') }}" min="1" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                                @error('estimated_guests')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Venue</label>
                                <select name="preferred_venue" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                                    <option value="">Pilih venue</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->name }}" @selected(old('preferred_venue') === $venue->name)>{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Wedding Style</label>
                                <select name="wedding_style" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                                    <option value="">Pilih style</option>
                                    @foreach($weddingStyles as $style)
                                        <option value="{{ $style }}" @selected(old('wedding_style') === $style)>{{ $style }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Budget Range</label>
                                <select name="budget_range" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">
                                    <option value="">Pilih budget</option>
                                    @foreach($budgetRanges as $range)
                                        <option value="{{ $range }}" @selected(old('budget_range') === $range)>{{ $range }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Layanan yang Dibutuhkan</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($services as $service)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}" @if(is_array(old('services')) && in_array($service->id, old('services'))) checked @endif class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ $service->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('services')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Pesan</label>
                            <textarea name="message" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="mt-6 w-full sm:w-auto px-8 py-3 bg-rose-700 hover:bg-rose-800 text-white font-semibold rounded-lg transition">
                            Kirim Permintaan Konsultasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
