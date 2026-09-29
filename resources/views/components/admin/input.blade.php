@props(['value' => null])

<input {{ $attributes->merge([
    'class' => 'block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white dark:placeholder:text-gray-500',
    'value' => $value,
]) }} />
