@props(['title' => 'Belum ada data', 'description' => null, 'icon' => 'inbox'])

<div class="flex flex-col items-center justify-center px-6 py-14 text-center">
    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 dark:bg-white/[0.05] dark:text-gray-500">
        <x-admin.icon :name="$icon" class="h-6 w-6" />
    </span>

    <p class="mt-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $title }}</p>

    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
    @endif

    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
