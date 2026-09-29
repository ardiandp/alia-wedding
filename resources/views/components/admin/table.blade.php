@props(['pagination' => null])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-card dark:border-gray-800 dark:bg-white/[0.03] dark:shadow-card-dark']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left dark:divide-gray-800">
            @isset($head)
                <thead class="bg-gray-50 dark:bg-white/[0.02]">
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>
            @endisset

            {{ $slot }}
        </table>
    </div>

    @if ($pagination instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
            @if ($pagination instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                {{ $pagination->onEachSide(1)->withQueryString()->links() }}
            @else
                {{ $pagination->links() }}
            @endif
        </div>
    @endif
</div>
