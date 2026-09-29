@props(['title', 'subtitle' => null, 'back' => null])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div class="min-w-0">
        @if ($back)
            <a href="{{ $back }}"
               class="mb-2 inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400">
                <x-admin.icon name="chevron-right" class="h-4 w-4 rotate-180" />
                Kembali
            </a>
        @endif

        <h1 class="truncate text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>

        @if ($subtitle)
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</div>
