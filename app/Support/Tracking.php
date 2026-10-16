<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Helpers for privacy-preserving, cookie-free traffic tracking.
 *
 * Visitors are identified by a salted SHA-256 digest of IP + user agent + date.
 * No raw IP, no cookie, and no third party is involved.
 */
class Tracking
{
    private const BOT_PATTERNS = 'bot|crawl|spider|slurp|crawling|bingbot|yandex|baidu|duckduckbot|sogou|exabot|facebot|ia_archiver|preview|monitor|uptimerobot|pingdom|lighthouse|headless|phantomjs|slimerjs|wget|curl|python-requests|go-http-client|java|okhttp|axios|node-fetch|scrapy|ahrefs|semrush|mj12bot|dotbot|seznambot|yisouspider|petalbot|bytespider|gptbot|ccbot|claudebot|perplexity';

    public static function visitorHash(Request $request): string
    {
        $seed = $request->ip().'|'.$request->userAgent().'|'.today()->toDateString();

        return hash('sha256', $seed.'|'.static::salt());
    }

    public static function ipHash(Request $request): ?string
    {
        $ip = $request->ip();

        if (blank($ip)) {
            return null;
        }

        return hash('sha256', $ip.'|'.static::salt());
    }

    public static function isBot(?string $userAgent): bool
    {
        if (blank($userAgent)) {
            return true;
        }

        return (bool) preg_match('/('.static::BOT_PATTERNS.')/i', $userAgent);
    }

    public static function device(?string $userAgent): string
    {
        if (blank($userAgent)) {
            return 'unknown';
        }

        if (preg_match('/ipad|tablet|playbook|silk/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/mobi|iphone|ipod|android.*mobile|blackberry|iemobile|opera mini/i', $userAgent)) {
            return 'mobile';
        }

        if (preg_match('/android|kindle|silk|phone|mobile/i', $userAgent)) {
            return 'tablet';
        }

        return 'desktop';
    }

    public static function referrerHost(?string $referrer): ?string
    {
        if (blank($referrer)) {
            return null;
        }

        $host = parse_url($referrer, PHP_URL_HOST);

        if (blank($host)) {
            return null;
        }

        return Str::limit($host, 150, '');
    }

    /**
     * A per-installation salt so the digests cannot be reversed across sites.
     */
    private static function salt(): string
    {
        return substr((string) config('app.key'), 0, 32);
    }
}
