@props(['name', 'label', 'value' => null, 'hint' => null])

<label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.03]">
    <input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $value))
           class="mt-0.5 rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03]" />

    <span class="min-w-0">
        <span class="block text-sm font-medium text-gray-800 dark:text-gray-200">{{ $label }}</span>

        @if ($hint)
            <span class="mt-0.5 block text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</span>
        @endif
    </span>
</label>
