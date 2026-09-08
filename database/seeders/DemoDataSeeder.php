<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\HomepageContent;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Venue;
use App\Models\VenueFacility;
use App\Models\VenueImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedVenues();
        $this->seedServices();
        $this->seedPackages();
        $this->seedEvents();
        $this->seedGalleries();
        $this->seedTestimonials();
        $this->seedTeams();
        $this->seedAbout();
        $this->seedHomepage();
    }

    private function seedVenues(): void
    {
        $venues = [
            [
                'name' => 'Grand Ballroom',
                'capacity' => 800,
                'type' => 'indoor',
                'size' => 1200,
                'starting_price' => 150000000,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Ballroom megah dengan kapasitas hingga 800 tamu, cocok untuk pernikahan mewah dan acara corporate.',
                'facilities' => 'AC sentral, lighting profesional, sound system lengkap, ruang ganti pengantin, VIP lounge',
                'parking' => 'Parkir luas hingga 200 kendaraan',
                'catering' => 'Kerjasama dengan 5 catering premium',
                'decoration' => 'Custom decoration sesuai tema',
                'address' => 'Jl. Grand Premiere No. 10, Jakarta',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.',
            ],
            [
                'name' => 'Garden Pavilion',
                'capacity' => 500,
                'type' => 'outdoor',
                'size' => 900,
                'starting_price' => 120000000,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Venue outdoor dengan taman hijau asri, ideal untuk pernikahan garden party dan intimate wedding.',
                'facilities' => 'Taman tropis, gazebo, lighting taman, area cocktail',
                'parking' => 'Valet dan parkir tamu',
                'catering' => 'Outdoor catering dengan food stall',
                'decoration' => 'Dekorasi floral dan instalasi taman',
                'address' => 'Jl. Taman Asri Blok C, Bandung',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.',
            ],
            [
                'name' => 'Skyline Rooftop',
                'capacity' => 300,
                'type' => 'indoor_outdoor',
                'size' => 600,
                'starting_price' => 90000000,
                'is_featured' => false,
                'is_active' => true,
                'description' => 'Venue rooftop dengan pemandangan skyline kota, sempurna untuk reception dan pre-wedding.',
                'facilities' => 'Pemandangan kota 360°, glass balustrade, indoor-outdoor area',
                'parking' => 'Parkir basement gedung',
                'catering' => 'Fine dining catering tersedia',
                'decoration' => 'Dekorasi modern elegan',
                'address' => 'Jl. Skyline Tower Lt. 30, Jakarta',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.',
            ],
            [
                'name' => 'Crystal Hall',
                'capacity' => 1000,
                'type' => 'indoor',
                'size' => 1500,
                'starting_price' => 200000000,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Hall mewah dengan dekorasi kristal dan kapasitas hingga 1000 tamu untuk acara berskala besar.',
                'facilities' => 'Crystal chandelier, VIP room, ballroom besar, backstage area',
                'parking' => 'Parkir super luas dengan shuttle',
                'catering' => 'Multi-branch premium catering',
                'decoration' => 'Dekorasi kristal dan floral premium',
                'address' => 'Jl. Crystal Square No. 5, Surabaya',
                'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.',
            ],
        ];

        foreach ($venues as $data) {
            $facilitiesRaw = $data['facilities'];
            unset($data['facilities']);
            $data['slug'] = Str::slug($data['name']);
            $data['facility_note'] = $facilitiesRaw;
            $venue = Venue::create($data);

            $facilities = explode(', ', $facilitiesRaw);
            foreach ($facilities as $i => $facility) {
                VenueFacility::create([
                    'venue_id' => $venue->id,
                    'name' => $facility,
                ]);
            }

            $images = ['https://picsum.photos/seed/venue'.$venue->id.'/1200/800', 'https://picsum.photos/seed/venue2'.$venue->id.'/1200/800', 'https://picsum.photos/seed/venue3'.$venue->id.'/1200/800'];
            foreach ($images as $i => $image) {
                VenueImage::create([
                    'venue_id' => $venue->id,
                    'image' => $image,
                    'caption' => $venue->name.' - Foto '.($i + 1),
                    'sort_order' => $i,
                ]);
            }
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['name' => 'Wedding Venue', 'slug' => 'wedding-venue', 'icon' => 'building'],
            ['name' => 'Wedding Organizer', 'slug' => 'wedding-organizer', 'icon' => 'sparkles'],
            ['name' => 'Decoration', 'slug' => 'decoration', 'icon' => 'flower'],
            ['name' => 'Catering', 'slug' => 'catering', 'icon' => 'utensils'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'icon' => 'music'],
            ['name' => 'Documentation', 'slug' => 'documentation', 'icon' => 'camera'],
        ];

        foreach ($services as $i => $service) {
            Service::create($service + [
                'description' => 'Layanan '.$service['name'].' premium untuk pernikahan Anda.',
                'image' => 'https://picsum.photos/seed/service'.$i.'/800/600',
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }

    private function seedPackages(): void
    {
        $packages = [
            ['name' => 'Silver Package', 'price' => 85000000, 'price_type' => 'fixed', 'guest_capacity' => 200, 'is_featured' => false, 'items' => ['Venue', 'Catering (200 pax)', 'Dekorasi Basic', 'Sound System', 'MC']],
            ['name' => 'Gold Package', 'price' => 150000000, 'price_type' => 'fixed', 'guest_capacity' => 400, 'is_featured' => true, 'items' => ['Venue', 'Catering (400 pax)', 'Dekorasi Standard', 'Sound System', 'Entertainment', 'Wedding Organizer']],
            ['name' => 'Platinum Package', 'price' => 250000000, 'price_type' => 'fixed', 'guest_capacity' => 800, 'is_featured' => true, 'items' => ['Venue', 'Catering (800 pax)', 'Dekorasi Premium', 'Sound System', 'Entertainment', 'Wedding Organizer', 'Dokumentasi', 'Makeup']],
            ['name' => 'Custom Package', 'price' => null, 'price_type' => 'custom', 'guest_capacity' => null, 'is_featured' => false, 'items' => ['Venue', 'Sesuai kebutuhan']],
        ];

        foreach ($packages as $data) {
            $items = $data['items'];
            unset($data['items']);
            $package = Package::create($data + ['slug' => Str::slug($data['name']), 'is_active' => true]);

            foreach ($items as $i => $item) {
                PackageItem::create([
                    'package_id' => $package->id,
                    'name' => $item,
                    'sort_order' => $i,
                ]);
            }
        }
    }

    private function seedEvents(): void
    {
        $venues = Venue::pluck('id')->all();
        $events = [
            ['title' => 'Wedding Expo 2026', 'event_type' => 'expo', 'start_date' => now()->addDays(10)->format('Y-m-d'), 'end_date' => now()->addDays(12)->format('Y-m-d'), 'status' => 'published'],
            ['title' => 'Open House & Venue Tour', 'event_type' => 'open_house', 'start_date' => now()->addDays(20)->format('Y-m-d'), 'end_date' => now()->addDays(20)->format('Y-m-d'), 'status' => 'published'],
            ['title' => 'Food Testing Session', 'event_type' => 'food_testing', 'start_date' => now()->addDays(15)->format('Y-m-d'), 'end_date' => null, 'status' => 'published'],
            ['title' => 'Wedding Package Launch', 'event_type' => 'promotion', 'start_date' => now()->addDays(5)->format('Y-m-d'), 'end_date' => now()->addDays(30)->format('Y-m-d'), 'status' => 'published'],
        ];

        foreach ($events as $i => $data) {
            Event::create(array_merge($data, [
                'slug' => Str::slug($data['title']),
                'venue_id' => $i % count($venues) === 0 ? $venues[0] : $venues[$i % count($venues)],
                'start_time' => '10:00:00',
                'end_time' => '21:00:00',
                'image' => 'https://picsum.photos/seed/event'.$i.'/1200/600',
                'description' => 'Acara '.$data['title'].' di Alia Wedding.',
            ]));
        }
    }

    private function seedGalleries(): void
    {
        $categories = ['venue', 'wedding', 'decoration', 'reception', 'bride_groom', 'table_setting', 'garden', 'real_wedding'];
        foreach ($categories as $catIndex => $category) {
            for ($i = 0; $i < 4; $i++) {
                Gallery::create([
                    'title' => Str::title(str_replace('_', ' ', $category)).' '.($i + 1),
                    'category' => $category,
                    'image' => 'https://picsum.photos/seed/gal'.$category.$i.'/800/600',
                    'description' => 'Galeri '.str_replace('_', ' ', $category),
                    'sort_order' => $catIndex * 4 + $i,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function seedTestimonials(): void
    {
        $venues = Venue::pluck('id')->all();
        $data = [
            ['customer_name' => 'Sarah', 'partner_name' => 'Daniel', 'rating' => 5, 'testimonial' => 'Beautiful venue and amazing service. Our wedding was perfect thanks to the wonderful team at Alia Wedding!', 'is_featured' => true],
            ['customer_name' => 'Dina', 'partner_name' => 'Andi', 'rating' => 5, 'testimonial' => 'Everything was beautifully arranged. The decoration and catering exceeded our expectations.', 'is_featured' => true],
            ['customer_name' => 'Michael', 'partner_name' => 'Jessica', 'rating' => 5, 'testimonial' => 'The team treated our wedding like their own. Professional, warm, and detail-oriented.', 'is_featured' => false],
            ['customer_name' => 'Rina', 'partner_name' => 'Budi', 'rating' => 4, 'testimonial' => 'Very satisfied with the venue and the wedding organizer. Highly recommended!', 'is_featured' => false],
        ];

        foreach ($data as $i => $item) {
            Testimonial::create(array_merge($item, [
                'wedding_date' => now()->subMonths($i + 1)->format('Y-m-d'),
                'venue_id' => $venues[$i % count($venues)],
                'photo' => 'https://picsum.photos/seed/testimonial'.$i.'/200/200',
                'is_active' => true,
            ]));
        }
    }

    private function seedTeams(): void
    {
        $data = [
            ['name' => 'Ayu Lestari', 'position' => 'Wedding Planner', 'description' => 'Wedding planner senior dengan 10 tahun pengalaman.'],
            ['name' => 'Bima Pratama', 'position' => 'Creative Director', 'description' => 'Mengarahkan desain dekorasi dan kreativitas acara.'],
            ['name' => 'Cinta Dewi', 'position' => 'Event Coordinator', 'description' => 'Memastikan setiap detail acara berjalan mulus.'],
            ['name' => 'Dedi Kurniawan', 'position' => 'Senior Photographer', 'description' => 'Dokumentasi terbaik untuk momen paling berharga.'],
        ];

        foreach ($data as $i => $item) {
            Team::create($item + [
                'photo' => 'https://picsum.photos/seed/team'.$i.'/400/400',
                'instagram' => 'https://instagram.com/aliawedding',
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }

    private function seedAbout(): void
    {
        About::create([
            'title' => 'Tentang Alia Wedding',
            'description' => 'Alia Wedding adalah penyedia venue pernikahan dan wedding organizer premium yang telah membantu ribuan pasangan mewujudkan hari bahagia mereka.',
            'image' => 'https://picsum.photos/seed/about/1200/800',
            'company_history' => 'Didirikan sejak 2015, Alia Wedding tumbuh menjadi salah satu destinasi pernikahan terpercaya di Indonesia dengan berbagai venue mewah dan layanan wedding organizer profesional.',
            'vision' => 'Menjadi penyedia pengalaman pernikahan terbaik di Indonesia.',
            'missions' => [
                'Memberikan layanan pernikahan premium yang personal',
                'Menciptakan momen tak terlupakan bagi setiap pasangan',
                'Menjalin kemitraan dengan vendor terbaik di industri',
            ],
        ]);
    }

    private function seedHomepage(): void
    {
        $content = [
            ['hero', 'heading', 'Your Dream Wedding Starts Here'],
            ['hero', 'description', 'Venue pernikahan premium dan wedding organizer profesional untuk hari bahagia Anda.'],
            ['hero', 'image', 'https://picsum.photos/seed/hero/1920/1080'],
            ['hero', 'cta_primary_text', 'Explore Venue'],
            ['hero', 'cta_primary_url', '/venues'],
            ['hero', 'cta_secondary_text', 'Consultation'],
            ['hero', 'cta_secondary_url', '/contact'],
            ['intro', 'title', 'Alia Wedding'],
            ['intro', 'description', 'Lebih dari sekadar venue pernikahan. Kami menciptakan pengalaman mewah yang akan Anda kenang selamanya.'],
            ['intro', 'image', 'https://picsum.photos/seed/intro/1200/800'],
            ['stats', 'happy_couples', '500'],
            ['stats', 'happy_couples_label', 'Happy Couples'],
            ['stats', 'years_experience', '10'],
            ['stats', 'years_experience_label', 'Years Experience'],
            ['stats', 'events_year', '50'],
            ['stats', 'events_year_label', 'Events Every Year'],
            ['stats', 'professional_vendors', '20'],
            ['stats', 'professional_vendors_label', 'Professional Vendors'],
            ['promotion', 'title', 'Special Wedding Package'],
            ['promotion', 'description', 'Book your wedding this month and get a complimentary decoration upgrade.'],
            ['promotion', 'cta_text', 'View Promotion'],
            ['promotion', 'cta_url', '/packages'],
            ['contact_cta', 'title', "Let's Create Your Perfect Wedding"],
            ['contact_cta', 'cta_text', 'Start Your Consultation'],
            ['contact_cta', 'cta_url', '/contact'],
        ];

        foreach ($content as [$section, $key, $value]) {
            HomepageContent::updateOrCreate(
                ['section' => $section, 'key' => $key],
                ['value' => $value]
            );
        }
    }
}
