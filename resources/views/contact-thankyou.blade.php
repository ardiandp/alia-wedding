<x-layouts.public :meta-title="'Terima Kasih | '.setting('site_name')">
    <section class="py-24 bg-rose-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-green-500 text-white flex items-center justify-center mb-8">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900">Terima Kasih!</h1>
            <p class="mt-4 text-gray-600 text-lg leading-relaxed">
                Permintaan konsultasi Anda telah kami terima.<br>
                Wedding consultant kami akan segera menghubungi Anda.
            </p>

            @php
                $waNum = setting('whatsapp_number', '6281234567890');
                $waMsg = setting('whatsapp_message', 'Halo, saya telah mengirim permintaan konsultasi. Mohon dapat dihubungi kembali.');
            @endphp
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ whatsapp_link($waNum, $waMsg) }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full transition">
                    Chat WhatsApp Sekarang
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-3 border-2 border-rose-700 text-rose-700 hover:bg-rose-700 hover:text-white font-semibold rounded-full transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
