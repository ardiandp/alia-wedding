<?php

namespace App\Support;

use App\Models\ClickEvent;
use App\Models\PageView;
use Illuminate\Support\Collection;

/**
 * Read-only queries behind the admin traffic dashboard.
 */
class Analytics
{
    public const RANGES = [7, 30, 90];

    public static function normaliseRange(mixed $range): int
    {
        return in_array((int) $range, self::RANGES, true) ? (int) $range : 30;
    }

    /**
     * @return array{range:int, views:int, visitors:int, today_views:int, today_visitors:int, pages_per_visit:float, clicks:int}
     */
    public static function summary(int $days = 30): array
    {
        $since = now()->subDays(max(1, $days) - 1)->startOfDay();

        $views = PageView::humans()->where('visited_at', '>=', $since)->count();
        $visitors = PageView::humans()
            ->where('visited_at', '>=', $since)
            ->distinct('visitor_hash')
            ->count('visitor_hash');

        $todayViews = PageView::humans()->where('visited_at', '>=', today())->count();
        $todayVisitors = PageView::humans()
            ->where('visited_at', '>=', today())
            ->distinct('visitor_hash')
            ->count('visitor_hash');

        $clicks = ClickEvent::recent($days)->count();

        return [
            'range' => $days,
            'views' => $views,
            'visitors' => $visitors,
            'today_views' => $todayViews,
            'today_visitors' => $todayVisitors,
            'pages_per_visit' => $visitors > 0 ? round($views / $visitors, 2) : 0.0,
            'clicks' => $clicks,
        ];
    }

    /**
     * @return array<string, array{views:int, visitors:int}>
     */
    public static function dailySeries(int $days = 30): array
    {
        return PageView::dailySeries($days);
    }

    /**
     * @return array<string, int>
     */
    public static function clickCounts(int $days = 30): array
    {
        return ClickEvent::recent($days)
            ->select('label')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('label')
            ->orderByDesc('total')
            ->pluck('total', 'label')
            ->map(fn ($total) => (int) $total)
            ->all();
    }

    /**
     * @return Collection<int, object{device:string, total:int}>
     */
    public static function devices(int $days = 30)
    {
        return PageView::humans()
            ->where('visited_at', '>=', now()->subDays(max(1, $days) - 1)->startOfDay())
            ->select('device')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('device')
            ->orderByDesc('total')
            ->get();
    }

    public static function topPages(int $days = 30, int $limit = 10)
    {
        return PageView::topPages($days, $limit);
    }

    public static function topReferrers(int $days = 30, int $limit = 10)
    {
        return PageView::topReferrers($days, $limit);
    }
}
