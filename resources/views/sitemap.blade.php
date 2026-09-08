<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($staticUrls as $url)
        <url>
            <loc>{{ $url }}</loc>
        </url>
    @endforeach

    @foreach($venues as $venue)
        <url>
            <loc>{{ $venue['loc'] }}</loc>
            @if($venue['lastmod'])
                <lastmod>{{ $venue['lastmod']->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
        </url>
    @endforeach

    @foreach($packages as $package)
        <url>
            <loc>{{ $package['loc'] }}</loc>
            @if($package['lastmod'])
                <lastmod>{{ $package['lastmod']->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
        </url>
    @endforeach

    @foreach($events as $event)
        <url>
            <loc>{{ $event['loc'] }}</loc>
            @if($event['lastmod'])
                <lastmod>{{ $event['lastmod']->toAtomString() }}</lastmod>
            @endif
            <changefreq>daily</changefreq>
        </url>
    @endforeach

    @foreach($articles as $article)
        <url>
            <loc>{{ $article['loc'] }}</loc>
            @if($article['lastmod'])
                <lastmod>{{ $article['lastmod']->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
</urlset>
