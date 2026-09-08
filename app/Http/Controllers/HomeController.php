<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\HomepageContent;
use App\Models\Package;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Venue;

class HomeController extends Controller
{
    public function index()
    {
        $hero = (object) HomepageContent::section('hero')->all();
        $intro = (object) HomepageContent::section('intro')->all();
        $promotion = (object) HomepageContent::section('promotion')->all();
        $contactCta = (object) HomepageContent::section('contact_cta')->all();

        $stats = [
            ['value' => HomepageContent::get('stats', 'happy_couples', 500), 'label' => HomepageContent::get('stats', 'happy_couples_label', 'Happy Couples')],
            ['value' => HomepageContent::get('stats', 'years_experience', 10), 'label' => HomepageContent::get('stats', 'years_experience_label', 'Years Experience')],
            ['value' => HomepageContent::get('stats', 'events_year', 50), 'label' => HomepageContent::get('stats', 'events_year_label', 'Events Every Year')],
            ['value' => HomepageContent::get('stats', 'professional_vendors', 20), 'label' => HomepageContent::get('stats', 'professional_vendors_label', 'Professional Vendors')],
        ];

        $venues = Venue::with('images')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->take(6)
            ->get();

        $services = Service::where('is_active', true)->orderBy('sort_order')->get();

        $packages = Package::with('items')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->take(4)
            ->get();

        $featuredTestimonials = Testimonial::with('venue')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->take(5)
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $upcomingEvents = Event::with('venue')
            ->where('status', 'published')
            ->where('start_date', '>=', now()->startOfDay())
            ->orderBy('start_date')
            ->take(4)
            ->get();

        return view('home', compact(
            'hero', 'intro', 'stats', 'promotion', 'contactCta',
            'venues', 'services', 'packages', 'featuredTestimonials',
            'galleries', 'upcomingEvents',
        ));
    }
}
