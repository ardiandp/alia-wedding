<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ $title ?? config('app.name', 'Laravel') }} — Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @include('partials.theme-script')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="adminShell" class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
            <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"></div>

            <!-- Sidebar -->
            @include('admin.partials.sidebar')

            <div class="lg:pl-64">
                <!-- Topbar -->
                @include('admin.partials.topbar')

                <!-- Page Content -->
                <main class="p-4 sm:p-6 lg:p-8">
                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset

                    @include('admin.partials.flash')

                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('adminShell', () => ({
                    sidebarOpen: false,

                    init() {
                        this.applyTheme(localStorage.getItem('theme') === 'dark' ||
                            (localStorage.getItem('theme') !== 'light' &&
                                window.matchMedia('(prefers-color-scheme: dark)').matches));
                    },

                    isDark() {
                        return document.documentElement.classList.contains('dark');
                    },

                    applyTheme(dark) {
                        document.documentElement.classList.toggle('dark', dark);
                        localStorage.setItem('theme', dark ? 'dark' : 'light');
                    },

                    toggleTheme() {
                        this.applyTheme(!this.isDark());
                    },
                }));
            });
        </script>
    </body>
</html>
