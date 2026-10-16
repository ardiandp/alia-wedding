<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\Package;
use App\Models\Venue;
use App\Support\Seo;

class PetaSitusController extends Controller
{
    public function index()
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();
        $packages = Package::where('is_active', true)->orderBy('name')->get();
        $events = Event::where('status', 'published')->orderByDesc('start_date')->get();
        $articles = Article::published()->orderByDesc('published_at')->get();
        $categories = Category::whereHas('articles', fn ($q) => $q->published())
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $staticPages = [
            ['label' => 'Beranda', 'url' => route('home'), 'note' => 'Halaman utama situs'],
            ['label' => 'Profil', 'url' => route('about'), 'note' => 'Tentang kami'],
            ['label' => 'Tim Kami', 'url' => route('team'), 'note' => 'Tim di balik Alia Wedding'],
            ['label' => 'Venue', 'url' => route('venues.index'), 'note' => 'Daftar venue pernikahan'],
            ['label' => 'Paket', 'url' => route('packages.index'), 'note' => 'Paket layanan pernikahan'],
            ['label' => 'Galeri', 'url' => route('gallery.index'), 'note' => 'Galeri foto'],
            ['label' => 'Agenda', 'url' => route('events.index'), 'note' => 'Agenda dan acara'],
            ['label' => 'Artikel', 'url' => route('articles.index'), 'note' => 'Artikel dan tips'],
            ['label' => 'Kontak', 'url' => route('contact'), 'note' => 'Formulir dan informasi kontak'],
            ['label' => 'Peta Situs', 'url' => route('peta-situs'), 'note' => 'Halaman ini'],
        ];

        return view('peta-situs', [
            'staticPages' => $staticPages,
            'venues' => $venues,
            'packages' => $packages,
            'events' => $events,
            'articles' => $articles,
            'categories' => $categories,
            'metaTitle' => 'Peta Situs | '.Seo::siteName(),
            'metaDescription' => 'Daftar lengkap halaman di '.Seo::siteName().': venue, paket, agenda, artikel, dan informasi kontak.',
        ]);
    }
}
