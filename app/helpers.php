<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Retrieve a setting value by key, or all settings.
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        static $cached = null;

        if ($cached === null) {
            $cached = Setting::pluck('value', 'key')->all();
        }

        if ($key === null) {
            return $cached;
        }

        return $cached[$key] ?? $default;
    }
}

if (! function_exists('format_rupiah')) {
    /**
     * Format an integer/decimal value into Indonesian Rupiah.
     */
    function format_rupiah(mixed $value, bool $full = false): string
    {
        if ($value === null || $value === '') {
            return 'Rp 0';
        }

        $amount = (float) $value;
        $formatted = number_format($amount, 0, ',', '.');

        return $full ? "Rp {$formatted}" : "Rp {$formatted}";
    }
}

if (! function_exists('image_url')) {
    /**
     * Resolve an image path into a usable URL.
     * Accepts full URLs, relative storage paths, or null.
     */
    function image_url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', 'data:', '//'])) {
            return $path;
        }

        return asset('storage/'.$path);
    }
}

if (! function_exists('whatsapp_link')) {
    /**
     * Build a WhatsApp wa.me link with an optional prefilled message.
     */
    function whatsapp_link(string $number, ?string $message = null): string
    {
        $clean = preg_replace('/[^0-9]/', '', $number);
        $clean = ltrim($clean, '0');
        if (! str_starts_with($clean, '62')) {
            $clean = '62'.$clean;
        }

        $url = "https://wa.me/{$clean}";

        if ($message) {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }
}
