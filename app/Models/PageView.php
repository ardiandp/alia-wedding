<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'path', 'route_name', 'page_title', 'visitor_hash', 'ip_hash',
    'user_agent', 'referrer', 'referrer_host', 'device', 'is_bot', 'visited_at',
])]
class PageView extends Model
{
    public $timestamps = true;

    protected $casts = [
        'is_bot' => 'boolean',
        'visited_at' => 'datetime',
    ];

    public function scopeHumans(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    /**
     * Daily series of page views / unique visitors over the last N days.
     *
     * @return array<string, array{views:int, visitors:int}>
     */
    public static function dailySeries(int $days = 30): array
    {
        $since = now()->subDays(max(1, $days) - 1)->startOfDay();

        $rows = static::humans()
            ->where('visited_at', '>=', $since)
            ->selectRaw('DATE(visited_at) as day')
            ->selectRaw('COUNT(*) as views')
            ->selectRaw('COUNT(DISTINCT visitor_hash) as visitors')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $series = [];

        for ($i = 0; $i < max(1, $days); $i++) {
            $date = now()->subDays($days - 1)->addDays($i);
            $key = $date->format('Y-m-d');
            $row = $rows->get($key);

            $series[$key] = [
                'views' => (int) ($row->views ?? 0),
                'visitors' => (int) ($row->visitors ?? 0),
            ];
        }

        return $series;
    }

    public static function topPages(int $days = 30, int $limit = 10)
    {
        return static::humans()
            ->where('visited_at', '>=', now()->subDays(max(1, $days))->startOfDay())
            ->select('path')
            ->selectRaw('COUNT(*) as views')
            ->selectRaw('COUNT(DISTINCT visitor_hash) as visitors')
            ->selectRaw('MAX(page_title) as page_title')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    public static function topReferrers(int $days = 30, int $limit = 10)
    {
        $siteHost = parse_url(config('app.url'), PHP_URL_HOST) ?: parse_url(url('/'), PHP_URL_HOST);

        return static::humans()
            ->whereNotNull('referrer_host')
            ->where('referrer_host', '!=', $siteHost)
            ->where('visited_at', '>=', now()->subDays(max(1, $days))->startOfDay())
            ->select('referrer_host')
            ->selectRaw('COUNT(*) as visits')
            ->selectRaw('COUNT(DISTINCT visitor_hash) as visitors')
            ->groupBy('referrer_host')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get();
    }
}
