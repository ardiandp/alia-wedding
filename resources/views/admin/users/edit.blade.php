@php
    $roleLabels = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'staff' => 'Staff',
    ];

    $roleTones = [
        'super_admin' => 'purple',
        'admin' => 'brand',
        'staff' => 'gray',
    ];

    $isLastSuperAdmin = $user->isSuperAdmin()
        && \App\Models\User::where('role', 'super_admin')->count() <= 1;
@endphp

<x-admin-layout title="Edit Pengguna">
    <x-admin.page-header :title="$user->name"
                          subtitle="Kelola akun dan hak akses pengguna"
                          :back="route('admin.users.index')">
        <x-slot:actions>
            <x-admin.badge :tone="$roleTones[$user->role] ?? 'gray'">
                {{ $roleLabels[$user->role] ?? $user->role }}
            </x-admin.badge>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-3xl space-y-5">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Akun">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" required>Nama Lengkap</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name', $user->name)" required />
                    <x-admin.error name="name" />
                </div>

                <div>
                    <x-admin.label for="email" required>Email</x-admin.label>
                    <x-admin.input id="email" name="email" type="email" :value="old('email', $user->email)" required />
                    <x-admin.error name="email" />
                </div>

                <div>
                    <x-admin.label for="password">Kata Sandi Baru</x-admin.label>
                    <x-admin.input id="password" name="password" type="password" autocomplete="new-password" />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                    <x-admin.error name="password" />
                </div>

                <div>
                    <x-admin.label for="password_confirmation">Konfirmasi Kata Sandi</x-admin.label>
                    <x-admin.input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                    <x-admin.error name="password_confirmation" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Hak Akses">
            <x-admin.select name="role" required :disabled="$isLastSuperAdmin ? true : null">
                @foreach ($roleLabels as $value => $label)
                    <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
                @endforeach
            </x-admin.select>
            <x-admin.error name="role" />

            @if ($isLastSuperAdmin)
                <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                    Ini Super Admin terakhir, role tidak dapat diubah.
                </p>
            @endif
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Perubahan</x-admin.button>
            <x-admin.button :href="route('admin.users.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
