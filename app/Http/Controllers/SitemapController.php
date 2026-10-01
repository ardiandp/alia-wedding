<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Package;
use App\Models\Venue;
use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        if (! Seo::indexingAllowed()) {
            return $this->robots();
        }

        $staticUrls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('about'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('team'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('venues.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => route('packages.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => route('gallery.index'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('events.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('articles.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('contact'), 'priority' => '0.6', 'changefreq' => 'yearly'],
        ];

        $venues = Venue::where('is_active', true)->get()
            ->map(fn (Venue $v) => [
                'loc' => route('venues.show', $v),
                'lastmod' => $v->updated_at,
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ]);
        $packages = Package::where('is_active', true)->get()
            ->map(fn (Package $p) => [
                'loc' => route('packages.show', $p),
                'lastmod' => $p->updated_at,
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ]);
        $events = Event::where('status', 'published')->get()
            ->map(fn (Event $e) => [
                'loc' => route('events.show', $e),
                'lastmod' => $e->updated_at,
                'priority' => '0.7',
                'changefreq' => 'daily',
            ]);
        $articles = Article::published()->get()
            ->map(fn (Article $a) => [
                'loc' => route('articles.show', $a),
                'lastmod' => $a->updated_at,
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ]);

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
        if (! Seo::indexingAllowed()) {
            $content = "User-agent: *\nDisallow: /\n";

            return response($content)->header('Content-Type', 'text/plain');
        }

        $content = "User-agent: *\nAllow: /\n";
        $content .= "\nDisallow: /admin\nDisallow: /dashboard\nDisallow: /login\nDisallow: /register\n";
        $content .= "\nSitemap: ".url('/sitemap.xml')."\n";

        return response($content)->header('Content-Type', 'text/plain');
    }
}
