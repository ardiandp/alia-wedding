@php
    $selected = array_map('intval', (array) $selected);
@endphp

@if ($categories->isEmpty())
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Belum ada kategori.
        <a href="{{ route('admin.categories.create') }}" class="font-medium text-brand-600 hover:underline dark:text-brand-400">Tambah kategori</a>.
    </p>
@else
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($categories as $category)
            <label class="flex items-center gap-2.5 rounded-lg border border-gray-200 px-3 py-2 text-sm transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.02]">
                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                       @checked(in_array($category->id, $selected, true))
                       class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500 dark:border-gray-700 dark:bg-white/[0.03]" />
                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $category->name }}</span>
            </label>
        @endforeach
    </div>
@endif
