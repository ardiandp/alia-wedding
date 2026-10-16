<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($staticUrls as $entry)
        @php $loc = is_string($entry) ? $entry : $entry['loc']; @endphp
        <url>
            <loc>{{ $loc }}</loc>
            @if(! is_string($entry))
                @if($entry['changefreq'] ?? null)
                    <changefreq>{{ $entry['changefreq'] }}</changefreq>
                @endif
                @if($entry['priority'] ?? null)
                    <priority>{{ $entry['priority'] }}</priority>
                @endif
            @endif
        </url>
    @endforeach

    @foreach($venues as $venue)
        <url>
            <loc>{{ $venue['loc'] }}</loc>
            @if($venue['lastmod'])
                <lastmod>{{ $venue['lastmod']->toAtomString() }}</lastmod>
            @endif
            @if($venue['changefreq'] ?? null)
                <changefreq>{{ $venue['changefreq'] }}</changefreq>
            @endif
            @if($venue['priority'] ?? null)
                <priority>{{ $venue['priority'] }}</priority>
            @endif
        </url>
    @endforeach

    @foreach($packages as $package)
        <url>
            <loc>{{ $package['loc'] }}</loc>
            @if($package['lastmod'])
                <lastmod>{{ $package['lastmod']->toAtomString() }}</lastmod>
            @endif
            @if($package['changefreq'] ?? null)
                <changefreq>{{ $package['changefreq'] }}</changefreq>
            @endif
            @if($package['priority'] ?? null)
                <priority>{{ $package['priority'] }}</priority>
            @endif
        </url>
    @endforeach

    @foreach($events as $event)
        <url>
            <loc>{{ $event['loc'] }}</loc>
            @if($event['lastmod'])
                <lastmod>{{ $event['lastmod']->toAtomString() }}</lastmod>
            @endif
            @if($event['changefreq'] ?? null)
                <changefreq>{{ $event['changefreq'] }}</changefreq>
            @endif
            @if($event['priority'] ?? null)
                <priority>{{ $event['priority'] }}</priority>
            @endif
        </url>
    @endforeach

    @foreach($articles as $article)
        <url>
            <loc>{{ $article['loc'] }}</loc>
            @if($article['lastmod'])
                <lastmod>{{ $article['lastmod']->toAtomString() }}</lastmod>
            @endif
            @if($article['changefreq'] ?? null)
                <changefreq>{{ $article['changefreq'] }}</changefreq>
            @endif
            @if($article['priority'] ?? null)
                <priority>{{ $article['priority'] }}</priority>
            @endif
        </url>
    @endforeach

    @foreach($categories as $category)
        <url>
            <loc>{{ $category['loc'] }}</loc>
            @if($category['lastmod'])
                <lastmod>{{ $category['lastmod']->toAtomString() }}</lastmod>
            @endif
            @if($category['changefreq'] ?? null)
                <changefreq>{{ $category['changefreq'] }}</changefreq>
            @endif
            @if($category['priority'] ?? null)
                <priority>{{ $category['priority'] }}</priority>
            @endif
        </url>
    @endforeach
</urlset>