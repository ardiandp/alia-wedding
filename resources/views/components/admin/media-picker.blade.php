@props([
    'name' => null,
    'label' => null,
    'value' => null,
    'hint' => null,
])

@php
    $current = old($name, $value);
    $pickerInit = Illuminate\Support\Js::from([
        'value' => $current,
        'preview' => image_url($current),
        'uploadUrl' => route('admin.media.store'),
        'browserUrl' => route('admin.media.browser'),
    ]);
@endphp

<div class="space-y-3">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    @endif

    <div x-data="mediaPicker({{ $pickerInit }}, @js($name))">
        <div class="flex items-start gap-4">
            <div class="relative h-28 w-40 shrink-0 overflow-hidden rounded-md bg-gray-100 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <template x-if="preview">
                    <img :src="preview" alt="Preview" class="h-full w-full object-cover">
                </template>
                <template x-if="!preview">
                    <div class="flex h-full w-full flex-col items-center justify-center gap-1 text-gray-300 dark:text-gray-600">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <span class="text-xs">Belum ada gambar</span>
                    </div>
                </template>
            </div>

            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" @click="openBrowser"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800">
                        Pilih dari Media
                    </button>
                    <label class="relative inline-flex cursor-pointer items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Upload Baru
                        <input type="file" accept="image/jpeg,image/png,image/webp" class="absolute inset-0 h-full w-full cursor-pointer opacity-0" @change="upload($event)">
                    </label>
                    <button type="button" x-show="value" @click="clearValue"
                            class="rounded-md px-3 py-2 text-sm font-medium text-red-600 transition hover:text-red-500">
                        Hapus
                    </button>
                </div>

                <p x-show="uploading" class="text-sm text-gray-500 dark:text-gray-400">Mengupload…</p>
                <p x-show="error" x-text="error" class="text-sm text-red-600 dark:text-red-400"></p>
                @if ($hint)
                    <p class="text-xs text-gray-400">{{ $hint }}</p>
                @endif

                <input type="hidden" :name="fieldName" :value="value">
                <x-input-error :messages="$errors->get($name)" class="mt-2" />
            </div>
        </div>

        <div x-show="browserOpen"
             x-transition.opacity
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4"
             @keydown.escape.window="browserOpen = false">
            <div class="w-full max-w-3xl overflow-hidden rounded-lg bg-white shadow-xl dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Pilih dari Media Library</h3>
                    <button type="button" @click="browserOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto p-6">
                    <div x-html="browserHtml"></div>
                </div>
            </div>
        </div>
    </div>
</div>