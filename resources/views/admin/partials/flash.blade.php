@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="flex items-start justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200">
        <span class="font-medium">{{ session('success') }}</span>
        <button type="button" @click="show = false" class="ml-4 text-green-600 hover:text-green-800 dark:text-green-300 dark:hover:text-green-100">&times;</button>
    </div>
@endif