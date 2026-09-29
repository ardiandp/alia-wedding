@props([
    'label',
    'value',
    'icon' => 'grid',
    'href' => null,
    'tone' => 'brand',
    'hint' => null,
])

@php
    $tones = [
        'brand' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-300',
        'green' => 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-300',
        'amber' => 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-300',
        'red' => 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-300',
        'blue' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-300',
        'purple' => 'bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-300',
    ];

    $toneClass = $tones[$tone] ?? $tones['brand'];
    $wrapper = 'block rounded-2xl border border-gray-200 bg-white p-5 shadow-card transition hover:border-brand-300 hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-brand-500/40 dark:shadow-card-dark';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $wrapper]) }}>
@else
    <div {{ $attributes->merge(['class' => $wrapper]) }}>
@endif
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>

            @if ($hint)
                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ $hint }}</p>
            @endif
        </div>

        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $toneClass }}">
            <x-admin.icon :name="$icon" class="h-5 w-5" />
        </span>
    </div>
@if ($href)
    </a>
@else
    </div>
@endif
