<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            SettingsSeeder::class,
            UserSeeder::class,
            MediaLibrarySeeder::class,
            DemoDataSeeder::class,
        ];

        // Demo traffic is skipped while testing so assertions stay deterministic.
        if (! app()->runningUnitTests()) {
            $seeders[] = AnalyticsSeeder::class;
        }

        $this->call($seeders);
    }
}
