@props(['title' => null, 'subtitle' => null, 'padded' => true])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 bg-white shadow-card dark:border-gray-800 dark:bg-white/[0.03] dark:shadow-card-dark']) }}>
    @if ($title || isset($actions))
        <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                @endif

                @if ($subtitle)
                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div class="{{ $padded ? 'p-5' : '' }}">
        {{ $slot }}
    </div>
</div>
