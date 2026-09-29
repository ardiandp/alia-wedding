@if (session('success') || session('error'))
    <div class="mb-5 space-y-3">
        @foreach (['success' => ['green', 'check'], 'error' => ['red', 'x']] as $key => [$tone, $icon])
            @if (session($key))
                <div x-data="{ show: true }" x-show="show"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-init="setTimeout(() => show = false, 5000)"
                     role="alert"
                     class="flex items-start gap-3 rounded-2xl border px-4 py-3.5 text-sm {{ $tone === 'green'
                        ? 'border-green-200 bg-green-50 text-green-800 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-300'
                        : 'border-red-200 bg-red-50 text-red-800 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300' }}">

                    <span class="mt-0.5 shrink-0">
                        <x-admin.icon :name="$icon" class="h-4 w-4" />
                    </span>

                    <p class="flex-1 font-medium">{{ session($key) }}</p>

                    <button type="button" @click="show = false"
                            class="shrink-0 opacity-60 transition hover:opacity-100">
                        <x-admin.icon name="x" class="h-4 w-4" />
                    </button>
                </div>
            @endif
        @endforeach
    </div>
@endif
