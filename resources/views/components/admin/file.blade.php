@props(['hint' => null])

<input type="file" {{ $attributes->merge([
    'class' => 'block w-full cursor-pointer rounded-xl border border-gray-300 bg-white text-sm text-gray-600 shadow-sm transition file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03] dark:text-gray-400 dark:file:bg-white/10 dark:file:text-white dark:file:hover:bg-white/20',
]) }} />

@if ($hint)
    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
@endif
