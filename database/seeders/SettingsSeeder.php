<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            'site_name' => 'Alia Wedding',
            'site_tagline' => 'Wedding Venue & Organizer',
            'site_description' => 'Mewujudkan pernikahan impian Anda dengan venue premium dan layanan wedding organizer profesional.',
            'contact_email' => 'hello@aliawedding.com',
            'contact_phone' => '+6281234567890',

            // WhatsApp
            'whatsapp_number' => '6281234567890',
            'whatsapp_message' => 'Halo, saya tertarik dengan layanan wedding venue Anda.',
            'whatsapp_floating_enabled' => '1',

            // Social Media
            'instagram_url' => 'https://instagram.com/aliawedding',
            'facebook_url' => 'https://facebook.com/aliawedding',
            'tiktok_url' => 'https://tiktok.com/@aliawedding',
            'youtube_url' => 'https://youtube.com/@aliawedding',

            // Address / Maps
            'address' => 'Jl. Raya Wedding No. 1, Jakarta Selatan',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.',
            'operational_hours' => 'Senin - Minggu, 09.00 - 21.00',

            // SEO
            'seo_default_title' => 'Alia Wedding | Wedding Venue & Organizer Premium',
            'seo_default_description' => 'Venue pernikahan premium dengan wedding organizer profesional di Indonesia.',
            'seo_default_og_image' => null,
            'seo_google_site_verification' => null,
            'seo_allow_indexing' => '1',
        ];

        $seoKeys = [
            'seo_default_title',
            'seo_default_description',
            'seo_default_og_image',
            'seo_google_site_verification',
            'seo_allow_indexing',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => in_array($key, $seoKeys, true) ? 'seo' : 'general']
            );
        }
    }
}
