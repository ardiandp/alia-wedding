@props([
    'variant' => 'primary',
    'href' => null,
    'icon' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:cursor-not-allowed disabled:opacity-50';

    $variants = [
        'primary' => 'bg-brand-600 text-white hover:bg-brand-700 focus:ring-brand-500',
        'secondary' => 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03] dark:text-gray-200 dark:hover:bg-white/[0.06]',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
        'ghost' => 'text-gray-600 hover:bg-gray-100 focus:ring-brand-500 dark:text-gray-300 dark:hover:bg-white/[0.06]',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

@if ($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $base.' '.$variantClass]) }}>
        @if ($icon)<x-admin.icon :name="$icon" class="h-4 w-4" />@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $base.' '.$variantClass]) }}>
        @if ($icon)<x-admin.icon :name="$icon" class="h-4 w-4" />@endif
        {{ $slot }}
    </button>
@endif
