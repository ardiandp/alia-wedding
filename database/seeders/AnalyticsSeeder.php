<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Package;
use App\Models\Venue;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Fills the traffic tables with believable data for the last 30 days so the
 * Statistik dashboard looks realistic. Re-runnable: existing rows are cleared.
 */
class AnalyticsSeeder extends Seeder
{
    private const DAYS = 30;

    private string $siteName = 'Alia Wedding';

    private array $mobileAgents = [
        'Mozilla/5.0 (Linux; Android 13; SM-S911B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
        'Mozilla/5.0 (Linux; Android 12; Pixel 6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Mobile Safari/537.36',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1',
        'Mozilla/5.0 (Linux; Android 13; Infinix X6819) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Mobile Safari/537.36',
        'Mozilla/5.0 (Linux; Android 11; Redmi Note 10) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Mobile Safari/537.36',
    ];

    private array $desktopAgents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36 Edg/119.0.0.0',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
    ];

    private array $tabletAgents = [
        'Mozilla/5.0 (iPad; CPU OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1',
        'Mozilla/5.0 (Linux; Android 13; SM-X700) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    ];

    private array $botAgents = [
        'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
        'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)',
        'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
        'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
        'Mozilla/5.0 (compatible; Pinterestbot/1.0; +http://www.pinterest.com/bot.html)',
    ];

    /** @var array<string, int> */
    private array $referrerWeights = [
        '' => 38,
        'https://www.google.com/' => 24,
        'https://www.google.co.id/' => 3,
        'https://www.instagram.com/' => 13,
        'https://l.instagram.com/' => 4,
        'https://www.facebook.com/' => 6,
        'https://m.facebook.com/' => 3,
        'https://www.tiktok.com/' => 3,
        'https://www.bing.com/' => 2,
        'https://www.pinterest.com/' => 2,
        'https://web.whatsapp.com/' => 2,
    ];

    public function run(): void
    {
        $this->siteName = setting('site_name') ?: 'Alia Wedding';

        // Keep the seeder idempotent so it can be re-run safely.
        DB::table('page_views')->delete();
        DB::table('click_events')->delete();

        $pages = $this->buildPagePool();
        $referrerPool = $this->referrers();

        $pageRows = [];
        $clickRows = [];

        for ($offset = self::DAYS - 1; $offset >= 0; $offset--) {
            $day = now()->subDays($offset)->startOfDay();
            $isWeekend = in_array($day->dayOfWeek, [CarbonInterface::SATURDAY, CarbonInterface::SUNDAY], true);
            $visitors = $this->visitorCount($offset, $isWeekend, $offset === 0);

            for ($v = 0; $v < $visitors; $v++) {
                $device = $this->weighted(['mobile' => 66, 'desktop' => 29, 'tablet' => 5]);
                $agent = $this->agentFor($device);
                $visitorHash = $this->hash();
                $ipHash = $this->hash();
                $sessionDepth = (int) $this->weighted([1 => 40, 2 => 25, 3 => 15, 4 => 10, 5 => 6, 6 => 4]);

                $referrer = $referrerPool[array_rand($referrerPool)];
                $referrerHost = $referrer ? parse_url($referrer, PHP_URL_HOST) : null;
                $sessionStart = $this->randomTimestamp($day);

                for ($p = 0; $p < $sessionDepth; $p++) {
                    $at = $sessionStart->copy()->addMinutes($p * random_int(1, 4) + random_int(0, 2));
                    $page = $pages[array_rand($pages)];

                    $pageRows[] = [
                        'path' => $page['path'],
                        'route_name' => $page['route'],
                        'page_title' => $page['title'],
                        'visitor_hash' => $visitorHash,
                        'ip_hash' => $ipHash,
                        'user_agent' => $agent,
                        'referrer' => $referrer,
                        'referrer_host' => $referrerHost,
                        'device' => $device,
                        'is_bot' => false,
                        'visited_at' => $at->toDateTimeString(),
                        'created_at' => $at->toDateTimeString(),
                        'updated_at' => $at->toDateTimeString(),
                    ];
                }

                // A small share of visitors tap a call-to-action button.
                if (random_int(1, 100) <= 4) {
                    $clickRows[] = $this->clickRow(
                        $this->weighted(['whatsapp' => 62, 'phone' => 12, 'contact' => 12, 'email' => 5, 'cta' => 9]),
                        $page,
                        $visitorHash,
                        $ipHash,
                        $sessionStart->copy()->addMinutes(random_int(1, 20)),
                    );
                }
            }

            // Search and social crawlers, recorded but flagged as bots.
            foreach (range(1, random_int(3, 9)) as $bot) {
                $at = $this->randomTimestamp($day);
                $page = $pages[array_rand($pages)];

                $pageRows[] = [
                    'path' => $page['path'],
                    'route_name' => $page['route'],
                    'page_title' => $page['title'],
                    'visitor_hash' => $this->hash(),
                    'ip_hash' => null,
                    'user_agent' => $this->botAgents[array_rand($this->botAgents)],
                    'referrer' => null,
                    'referrer_host' => null,
                    'device' => 'unknown',
                    'is_bot' => true,
                    'visited_at' => $at->toDateTimeString(),
                    'created_at' => $at->toDateTimeString(),
                    'updated_at' => $at->toDateTimeString(),
                ];
            }
        }

        foreach (array_chunk($pageRows, 500) as $chunk) {
            DB::table('page_views')->insert($chunk);
        }

        foreach (array_chunk($clickRows, 500) as $chunk) {
            DB::table('click_events')->insert($chunk);
        }

        $this->command?->info(sprintf(
            'AnalyticsSeeder: %s page views dan %s klik selama %s hari.',
            number_format(count($pageRows)),
            number_format(count($clickRows)),
            self::DAYS,
        ));
    }

    private function visitorCount(int $offset, bool $isWeekend, bool $isToday): int
    {
        $base = 95;
        $trend = 0.72 + (self::DAYS - 1 - $offset) / (self::DAYS - 1) * 0.53;
        $weekendBoost = $isWeekend ? 1.3 : 1.0;
        $noise = random_int(85, 120) / 100;

        $count = (int) round($base * $trend * $weekendBoost * $noise);

        if ($isToday) {
            $elapsed = now()->diffInSeconds(now()->startOfDay());
            $count = (int) round($count * max(0.15, $elapsed / 86400));
        }

        return max(5, $count);
    }

    /**
     * @return array<int, array{path:string, route:?string, title:string}>
     */
    private function buildPagePool(): array
    {
        $pool = [];

        $add = function (string $path, ?string $route, string $title, int $weight) use (&$pool) {
            for ($i = 0; $i < $weight; $i++) {
                $pool[] = ['path' => $path, 'route' => $route, 'title' => $title];
            }
        };

        $add('/', 'home', $this->siteName.' - Venue & Wedding Organizer Premium', 22);
        $add('/venues', 'venues.index', 'Venue Pernikahan | '.$this->siteName, 12);
        $add('/packages', 'packages.index', 'Paket Pernikahan | '.$this->siteName, 11);
        $add('/gallery', 'gallery.index', 'Galeri | '.$this->siteName, 8);
        $add('/artikel', 'articles.index', 'Artikel & Tips | '.$this->siteName, 6);
        $add('/agenda', 'events.index', 'Agenda | '.$this->siteName, 3);
        $add('/profil', 'about', 'Profil | '.$this->siteName, 2);
        $add('/tim-kami', 'team', 'Tim Kami | '.$this->siteName, 1);
        $add('/contact', 'contact', 'Kontak | '.$this->siteName, 4);

        foreach (Venue::where('is_active', true)->get(['name', 'slug']) as $venue) {
            $add('/venues/'.$venue->slug, 'venues.show', $venue->name.' | '.$this->siteName, 4);
        }

        foreach (Package::where('is_active', true)->get(['name', 'slug']) as $package) {
            $add('/packages/'.$package->slug, 'packages.show', $package->name.' | '.$this->siteName, 5);
        }

        foreach (Article::where('status', 'published')->get(['title', 'slug']) as $article) {
            $add('/artikel/'.$article->slug, 'articles.show', $article->title.' | '.$this->siteName, 2);
        }

        return $pool;
    }

    /**
     * @param  array<string, int>  $weights
     */
    private function weighted(array $weights): string
    {
        $pool = [];

        foreach ($weights as $value => $weight) {
            for ($i = 0; $i < $weight; $i++) {
                $pool[] = (string) $value;
            }
        }

        return $pool[array_rand($pool)];
    }

    /**
     * @return array<int, mixed>
     */
    private function referrers(): array
    {
        $weights = [
            '' => 38,
            'https://www.google.com/' => 24,
            'https://www.instagram.com/' => 13,
            'https://l.instagram.com/' => 4,
            'https://www.facebook.com/' => 6,
            'https://m.facebook.com/' => 3,
            'https://www.tiktok.com/' => 3,
            'https://www.bing.com/' => 2,
            'https://www.pinterest.com/' => 2,
            'https://web.whatsapp.com/' => 2,
            'https://www.google.co.id/' => 3,
        ];

        $pool = [];

        foreach ($weights as $value => $weight) {
            for ($i = 0; $i < $weight; $i++) {
                $pool[] = $value === '' ? null : $value;
            }
        }

        return $pool;
    }

    private function agentFor(string $device): string
    {
        return match ($device) {
            'mobile' => $this->mobileAgents[array_rand($this->mobileAgents)],
            'tablet' => $this->tabletAgents[array_rand($this->tabletAgents)],
            default => $this->desktopAgents[array_rand($this->desktopAgents)],
        };
    }

    private function randomTimestamp(Carbon $day): Carbon
    {
        $hour = (int) $this->weighted([
            0 => 1, 1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1,
            6 => 2, 7 => 3, 8 => 5, 9 => 8, 10 => 10, 11 => 11,
            12 => 12, 13 => 12, 14 => 11, 15 => 11, 16 => 12,
            17 => 13, 18 => 14, 19 => 15, 20 => 12, 21 => 10,
            22 => 6, 23 => 3,
        ]);

        return $day->copy()->setTime($hour, random_int(0, 59), random_int(0, 59));
    }

    /**
     * @param  array{path:string, route:?string, title:string}  $page
     * @return array<string, mixed>
     */
    private function clickRow(string $label, array $page, string $visitorHash, string $ipHash, Carbon $at): array
    {
        $target = match ($label) {
            'whatsapp' => 'https://wa.me/6281234567890',
            'email' => 'mailto:hello@aliawedding.id',
            default => $page['path'],
        };

        return [
            'label' => $label,
            'path' => $page['path'],
            'target' => $target,
            'visitor_hash' => $visitorHash,
            'ip_hash' => $ipHash,
            'created_at' => $at->toDateTimeString(),
        ];
    }

    private function hash(): string
    {
        return bin2hex(random_bytes(32));
    }
}
