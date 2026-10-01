<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UrlRedirect
{
    /**
     * Record a redirect for a changed slug, if the old path is not already taken.
     */
    public static function record(string $fromPath, string $toPath, int $statusCode = 301): void
    {
        $fromPath = static::normalizePath($fromPath);
        $toPath = static::normalizePath($toPath);

        if ($fromPath === $toPath || $fromPath === '/' || $toPath === '/') {
            return;
        }

        $query = DB::table('url_redirects')->where('from_path', $fromPath);

        if ($query->exists()) {
            $query->update(['to_path' => $toPath, 'status_code' => $statusCode]);

            return;
        }

        DB::table('url_redirects')->insert([
            'from_path' => $fromPath,
            'to_path' => $toPath,
            'status_code' => $statusCode,
            'hits' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Record a redirect for a slug change on a named public route.
     */
    public static function recordFor(string $routeName, string $parameter, string $fromSlug, string $toSlug, int $statusCode = 301): void
    {
        static::record(
            static::normalizePath(parse_url(route($routeName, [$parameter => $fromSlug]), PHP_URL_PATH) ?: ''),
            static::normalizePath(parse_url(route($routeName, [$parameter => $toSlug]), PHP_URL_PATH) ?: ''),
            $statusCode,
        );
    }

    /**
     * Resolve an incoming request path to a stored redirect target.
     */
    public static function resolveFor(string $requestPath): ?array
    {
        $path = static::normalizePath(parse_url($requestPath, PHP_URL_PATH) ?: '');

        if ($path === '/') {
            return null;
        }

        $row = DB::table('url_redirects')->where('from_path', $path)->first();

        if (! $row) {
            return null;
        }

        DB::table('url_redirects')
            ->where('id', $row->id)
            ->update([
                'hits' => DB::raw('hits + 1'),
                'last_hit_at' => now(),
            ]);

        return ['to_path' => $row->to_path, 'status_code' => (int) $row->status_code];
    }

    /**
     * Generate a unique slug for a model, appending a numeric suffix on collision.
     */
    public static function uniqueSlug(string $base, string $table, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base) ?: 'item';
        $candidate = $slug;
        $suffix = 2;

        while (
            DB::table($table)
                ->where('slug', $candidate)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = $slug.'-'.$suffix;
            $suffix++;
        }

        return $candidate;
    }

    /**
     * Normalize a path to a single leading slash and no trailing slash.
     */
    private static function normalizePath(string $path): string
    {
        return '/'.trim($path, '/');
    }
}
