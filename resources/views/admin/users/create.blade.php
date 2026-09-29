@php
    $roleLabels = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'staff' => 'Staff',
    ];

    $roleHints = [
        'super_admin' => 'Akses penuh, termasuk managesi pengguna dan role.',
        'admin' => 'Akses seluruh modul konten, media, pengaturan, dan pengguna.',
        'staff' => 'Hanya dashboard dan CRM prospek.',
    ];
@endphp

<x-admin-layout title="Tambah Pengguna">
    <x-admin.page-header title="Tambah Pengguna"
                          subtitle="Buat akun baru untuk tim Anda"
                          :back="route('admin.users.index')" />

    <form method="POST" action="{{ route('admin.users.store') }}" class="max-w-3xl space-y-5">
        @csrf

        <x-admin.card title="Informasi Akun">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" required>Nama Lengkap</x-admin.label>
                    <x-admin.input id="name" name="name" :value="old('name')" required autofocus />
                    <x-admin.error name="name" />
                </div>

                <div>
                    <x-admin.label for="email" required>Email</x-admin.label>
                    <x-admin.input id="email" name="email" type="email" :value="old('email')" required />
                    <x-admin.error name="email" />
                </div>

                <div>
                    <x-admin.label for="password" required>Kata Sandi</x-admin.label>
                    <x-admin.input id="password" name="password" type="password" required autocomplete="new-password" />
                    <x-admin.error name="password" />
                </div>

                <div>
                    <x-admin.label for="password_confirmation" required>Konfirmasi Kata Sandi</x-admin.label>
                    <x-admin.input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
                    <x-admin.error name="password_confirmation" />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Hak Akses" subtitle="Pilih role untuk pengguna ini.">
            <x-admin.select name="role" required>
                @foreach ($roleLabels as $value => $label)
                    <option value="{{ $value }}" @selected(old('role', 'staff') === $value)>{{ $label }}</option>
                @endforeach
            </x-admin.select>
            <x-admin.error name="role" />

            <ul class="mt-4 space-y-2">
                @foreach ($roleHints as $value => $hint)
                    <li class="flex items-start gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <x-admin.icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-green-500" />
                        <span><span class="font-medium text-gray-700 dark:text-gray-300">{{ $roleLabels[$value] }}</span> — {{ $hint }}</span>
                    </li>
                @endforeach
            </ul>
        </x-admin.card>

        <div class="flex items-center gap-3">
            <x-admin.button type="submit" icon="check">Simpan Pengguna</x-admin.button>
            <x-admin.button :href="route('admin.users.index')" variant="secondary">Batal</x-admin.button>
        </div>
    </form>
</x-admin-layout>
