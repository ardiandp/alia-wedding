<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Whitelisted, editable settings. Anything outside this list is rejected so
     * an admin cannot inject arbitrary keys into the settings table.
     */
    private const EDITABLE = [
        'site_name' => 'general',
        'site_tagline' => 'general',
        'site_description' => 'general',
        'contact_email' => 'general',
        'contact_phone' => 'general',
        'whatsapp_number' => 'general',
        'whatsapp_message' => 'general',
        'whatsapp_floating_enabled' => 'general',
        'instagram_url' => 'general',
        'facebook_url' => 'general',
        'tiktok_url' => 'general',
        'youtube_url' => 'general',
        'address' => 'general',
        'google_maps_embed' => 'general',
        'operational_hours' => 'general',
        'seo_default_title' => 'seo',
        'seo_default_description' => 'seo',
        'seo_default_og_image' => 'seo',
        'seo_google_site_verification' => 'seo',
        'seo_allow_indexing' => 'seo',
        'analytics_enabled' => 'analytics',
        'analytics_gsc_embed_url' => 'analytics',
    ];

    public function index(): View
    {
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach (self::EDITABLE as $key => $group) {
            $rules[$key] = match (true) {
                $key === 'seo_default_og_image' => ['nullable', 'string', 'max:255'],
                $key === 'analytics_gsc_embed_url' => ['nullable', 'url', 'max:2048'],
                default => ['nullable'],
            };
        }

        $validated = $request->validate($rules);

        foreach (self::EDITABLE as $key => $group) {
            if (! array_key_exists($key, $validated)) {
                continue;
            }

            $value = $validated[$key];

            if (in_array($key, ['whatsapp_floating_enabled', 'seo_allow_indexing', 'analytics_enabled'], true)) {
                $value = $request->boolean($key) ? '1' : '0';
            }

            if ($value === '') {
                $value = null;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group],
            );
        }

        setting_flush();

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
