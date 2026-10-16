<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use App\Support\Tracking;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Records one row per page load on public pages.
 *
 * Traffic is tracked cookie-free: only salted digests of IP + user agent are
 * stored, and the insert happens after the response has been sent so the page
 * itself is never slowed down.
 */
class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        $path = '/'.ltrim($request->path(), '/');
        $referer = $request->headers->get('referer');
        $userAgent = $request->userAgent();

        $row = [
            'path' => substr($path, 0, 255),
            'route_name' => $request->route()?->getName(),
            'page_title' => $this->pageTitle($response),
            'visitor_hash' => Tracking::visitorHash($request),
            'ip_hash' => Tracking::ipHash($request),
            'user_agent' => Str::limit($userAgent ?? '', 255, ''),
            'referrer' => Str::limit($referer ?? '', 255, ''),
            'referrer_host' => Tracking::referrerHost($referer),
            'device' => Tracking::device($userAgent),
            'is_bot' => Tracking::isBot($userAgent),
            'visited_at' => now(),
        ];

        // Persist after the response is flushed so tracking never adds latency.
        defer(fn () => PageView::create($row));

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (setting('analytics_enabled', '1') !== '1') {
            return false;
        }

        if (! $request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return false;
        }

        if ($request->user() !== null) {
            return false;
        }

        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return false;
        }

        return ! $this->isExcluded($request->path());
    }

    private function isExcluded(string $path): bool
    {
        $path = trim($path, '/');

        if ($path === '') {
            return false;
        }

        $excluded = [
            'admin', 'dashboard', 'login', 'register', 'profile', 'up',
            'sitemap.xml', 'robots.txt', 'track', 'storage', 'build',
        ];

        foreach ($excluded as $prefix) {
            if ($path === $prefix || Str::startsWith($path, $prefix.'/')) {
                return true;
            }
        }

        return Str::contains($path, '.');
    }

    private function pageTitle(Response $response): ?string
    {
        try {
            $content = $response->getContent();

            if (! is_string($content) || ! preg_match('/<title[^>]*>(.*?)<\/title>/is', $content, $matches)) {
                return null;
            }

            $title = html_entity_decode(trim($matches[1]), ENT_QUOTES, 'UTF-8');

            return Str::limit($title, 255, '');
        } catch (\Throwable) {
            return null;
        }
    }
}
