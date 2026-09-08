<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Package;
use App\Models\Venue;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticUrls = [
            route('home'),
            route('about'),
            route('team'),
            route('venues.index'),
            route('packages.index'),
            route('gallery.index'),
            route('events.index'),
            route('articles.index'),
            route('contact'),
        ];

        $venues = Venue::where('is_active', true)->get()
            ->map(fn (Venue $v) => ['loc' => route('venues.show', $v), 'lastmod' => $v->updated_at]);
        $packages = Package::where('is_active', true)->get()
            ->map(fn (Package $p) => ['loc' => route('packages.show', $p), 'lastmod' => $p->updated_at]);
        $events = Event::where('status', 'published')->get()
            ->map(fn (Event $e) => ['loc' => route('events.show', $e), 'lastmod' => $e->updated_at]);
        $articles = Article::published()->get()
            ->map(fn (Article $a) => ['loc' => route('articles.show', $a), 'lastmod' => $a->updated_at]);

        $content = response()->view('sitemap', [
            'staticUrls' => $staticUrls,
            'venues' => $venues,
            'packages' => $packages,
            'events' => $events,
            'articles' => $articles,
        ]);

        return $content->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\n";
        $content .= 'Sitemap: '.url('/sitemap.xml');

        return response($content)->header('Content-Type', 'text/plain');
    }
}
