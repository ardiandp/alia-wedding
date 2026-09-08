<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $metaTitle = $metaTitle ?? setting('seo_default_title', config('app.name'));
        $metaDesc = $metaDescription ?? setting('seo_default_description', '');
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-body antialiased bg-white text-gray-900">
    {{-- Top Navigation --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm" x-data="{ mobileOpen: false, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })" :class="{ 'shadow-md': scrolled }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-display text-xl lg:text-2xl font-bold tracking-tight text-rose-800">{{ setting('site_name', 'Alia Wedding') }}</span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-rose-700 transition">Home</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-gray-700 hover:text-rose-700 transition">Profil</a>
                    <a href="{{ route('venues.index') }}" class="text-sm font-medium text-gray-700 hover:text-rose-700 transition">Venue</a>
                    <a href="{{ route('packages.index') }}" class="text-sm font-medium text-gray-700 hover:text-rose-700 transition">Package</a>
                    <a href="{{ route('gallery.index') }}" class="text-sm font-medium text-gray-700 hover:text-rose-700 transition">Gallery</a>
                    <a href="{{ route('events.index') }}" class="text-sm font-medium text-gray-700 hover:text-rose-700 transition">Agenda</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-white bg-rose-700 hover:bg-rose-800 px-5 py-2.5 rounded-full transition">Konsultasi</a>
                </div>

                {{-- Mobile Hamburger --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-gray-700">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition.opacity x-cloak class="lg:hidden border-t bg-white">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block py-2.5 px-3 text-sm font-medium rounded-lg hover:bg-rose-50 text-gray-700">Home</a>
                <a href="{{ route('about') }}" class="block py-2.5 px-3 text-sm font-medium rounded-lg hover:bg-rose-50 text-gray-700">Profil</a>
                <a href="{{ route('venues.index') }}" class="block py-2.5 px-3 text-sm font-medium rounded-lg hover:bg-rose-50 text-gray-700">Venue</a>
                <a href="{{ route('packages.index') }}" class="block py-2.5 px-3 text-sm font-medium rounded-lg hover:bg-rose-50 text-gray-700">Package</a>
                <a href="{{ route('gallery.index') }}" class="block py-2.5 px-3 text-sm font-medium rounded-lg hover:bg-rose-50 text-gray-700">Gallery</a>
                <a href="{{ route('events.index') }}" class="block py-2.5 px-3 text-sm font-medium rounded-lg hover:bg-rose-50 text-gray-700">Agenda</a>
                <a href="{{ route('contact') }}" class="block py-2.5 px-3 text-sm font-medium text-center text-white bg-rose-700 rounded-lg">Konsultasi</a>
            </div>
        </div>
    </nav>

    {{-- Spacer for fixed nav --}}
    <div class="h-16 lg:h-20"></div>

    {{-- Page Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div>
                    <span class="font-display text-xl font-bold text-white">{{ setting('site_name', 'Alia Wedding') }}</span>
                    <p class="mt-3 text-sm leading-relaxed">{{ setting('site_description', '') }}</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Link</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('venues.index') }}" class="hover:text-white transition">Venue</a></li>
                        <li><a href="{{ route('packages.index') }}" class="hover:text-white transition">Package</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-white transition">Gallery</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Agenda</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ setting('address', '') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ setting('contact_phone', '') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ setting('contact_email', '') }}</span>
                        </li>
                    </ul>
                </div>

                {{-- Social --}}
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Social</h4>
                    <div class="flex gap-3">
                        @if(setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                        @if(setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if(setting('tiktok_url'))
                            <a href="{{ setting('tiktok_url') }}" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ setting('site_name', 'Alia Wedding') }}. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp Button --}}
    @php
        $waNumber = setting('whatsapp_number', '6281234567890');
        $waMessage = setting('whatsapp_message', 'Halo, saya tertarik dengan layanan wedding venue Anda.');
    @endphp
    @if(setting('whatsapp_floating_enabled', '1') === '1')
        <a href="{{ whatsapp_link($waNumber, $waMessage) }}"
           target="_blank"
           class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
           title="Chat WhatsApp">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
    @endif

    {{-- Mobile Bottom CTA --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t shadow-lg px-4 py-3 flex gap-3">
        <a href="{{ whatsapp_link($waNumber, $waMessage) }}" target="_blank" class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center text-sm font-semibold py-3 rounded-lg transition">
            WhatsApp
        </a>
        <a href="{{ route('contact') }}" class="flex-1 bg-rose-700 hover:bg-rose-800 text-white text-center text-sm font-semibold py-3 rounded-lg transition">
            Konsultasi
        </a>
    </div>
    <div class="lg:hidden h-16"></div>

    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "EventVenue",
        "name": "{{ setting('site_name') }}",
        "description": "{{ setting('site_description') }}",
        "url": "{{ url('/') }}",
        "telephone": "{{ setting('contact_phone') }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ setting('address') }}"
        }
    }
    </script>

    @stack('scripts')
</body>
</html>
