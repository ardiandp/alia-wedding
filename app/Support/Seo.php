<?php

namespace App\Support;

use Illuminate\Support\Str;

class Seo
{
    public const TITLE_LIMIT = 60;

    public const DESCRIPTION_LIMIT = 160;

    /**
     * Resolve the page title with a per-model override, then the site default.
     */
    public static function title(?string $modelTitle, ?string $metaTitle = null): string
    {
        $siteName = setting('site_name', config('app.name'));

        if (filled($metaTitle)) {
            return $metaTitle;
        }

        if (filled($modelTitle)) {
            return $modelTitle.' | '.$siteName;
        }

        return setting('seo_default_title', $siteName);
    }

    /**
     * Resolve the meta description with a per-model override and truncation fallback.
     */
    public static function description(?string $metaDescription, ?string $fallback = null): string
    {
        $description = filled($metaDescription) ? $metaDescription : $fallback;

        if (blank($description)) {
            $description = setting('seo_default_description', '');
        }

        return Str::limit((string) $description, self::DESCRIPTION_LIMIT, '');
    }

    /**
     * Resolve the Open Graph image with a fallback chain, always absolute.
     */
    public static function image(?string $modelImage, ?string $fallback = null): ?string
    {
        foreach ([$modelImage, $fallback, setting('seo_default_og_image')] as $candidate) {
            $url = image_url($candidate);

            if (filled($url)) {
                return url($url);
            }
        }

        return null;
    }

    /**
     * Normalise a user-supplied canonical URL to an absolute URL, or null.
     */
    public static function canonical(?string $canonicalUrl): ?string
    {
        if (blank($canonicalUrl)) {
            return null;
        }

        if (str_starts_with($canonicalUrl, 'http://') || str_starts_with($canonicalUrl, 'https://')) {
            return $canonicalUrl;
        }

        return url('/'.trim($canonicalUrl, '/'));
    }

    /**
     * Whether the site currently allows search engine indexing.
     */
    public static function indexingAllowed(): bool
    {
        return (bool) setting('seo_allow_indexing', '1');
    }

    public static function robots(): string
    {
        return self::indexingAllowed() ? 'index, follow' : 'noindex, nofollow';
    }

    public static function siteName(): string
    {
        return setting('site_name', config('app.name'));
    }

    public static function locale(): string
    {
        return app()->getLocale();
    }
}
