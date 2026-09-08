<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MediaLibrarySeeder extends Seeder
{
    public function run(): void
    {
        $library = media_library();

        $paths = [
            'seed/venues/garden-1.jpg',
            'seed/venues/grand-hall.jpg',
            'seed/venues/rooftop.jpg',
            'seed/venues/beachside.jpg',
            'seed/venues/classic.jpg',
            'seed/venues/garden-ext.jpg',
            'seed/packages/silver.jpg',
            'seed/packages/gold.jpg',
            'seed/packages/platinum.jpg',
            'seed/packages/diamond.jpg',
            'seed/events/expo.jpg',
            'seed/events/fair.jpg',
            'seed/galleries/g1.jpg',
            'seed/galleries/g2.jpg',
            'seed/galleries/g3.jpg',
            'seed/galleries/g4.jpg',
            'seed/galleries/g5.jpg',
            'seed/galleries/g6.jpg',
            'seed/testimonials/t1.jpg',
            'seed/testimonials/t2.jpg',
            'seed/testimonials/t3.jpg',
            'seed/teams/ella.jpg',
            'seed/teams/raka.jpg',
            'seed/teams/salsa.jpg',
            'seed/teams/dimas.jpg',
            'seed/services/s-akad.jpg',
            'seed/services/s-sangjit.jpg',
            'seed/services/s-resepsi.jpg',
            'seed/services/s-dekorasi.jpg',
            'seed/services/s-video.jpg',
            'seed/services/s-foto.jpg',
        ];

        foreach ($paths as $path) {
            $library->addMedia(storage_path('app/public/'.$path))
                ->preservingOriginal()
                ->toMediaCollection('uploads');
        }
    }
}
