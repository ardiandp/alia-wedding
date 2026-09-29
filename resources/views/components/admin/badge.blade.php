@props(['tone' => 'gray'])

@php
    $tones = [
        'gray' => 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300',
        'green' => 'bg-green-50 text-green-700 dark:bg-green-500/20 dark:text-green-300',
        'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
        'red' => 'bg-red-50 text-red-700 dark:bg-red-500/20 dark:text-red-300',
        'blue' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
        'brand' => 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300',
        'purple' => 'bg-purple-50 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300',
    ];

    $toneClass = $tones[$tone] ?? $tones['gray'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium '.$toneClass]) }}>
    {{ $slot }}
</span>
