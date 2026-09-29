@props(['href', 'icon' => 'eye', 'label' => null, 'variant' => 'secondary', 'confirm' => null])

@if ($confirm)
    <form method="POST" action="{{ $href }}" class="inline"
          onsubmit="return confirm(@js($confirm));">
        @csrf
        @method('DELETE')
        <x-admin.button type="submit" :variant="$variant" :icon="$icon">
            {{ $label ?? 'Hapus' }}
        </x-admin.button>
    </form>
@else
    <x-admin.button :href="$href" :variant="$variant" :icon="$icon">
        {{ $label ?? 'Hapus' }}
    </x-admin.button>
@endif
