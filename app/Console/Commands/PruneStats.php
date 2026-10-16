<?php

namespace App\Console\Commands;

use App\Models\ClickEvent;
use App\Models\PageView;
use Illuminate\Console\Command;

class PruneStats extends Command
{
    protected $signature = 'stats:prune {--days=180 : Number of days of traffic to keep}';

    protected $description = 'Delete page views and click events older than the retention window.';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $before = now()->subDays($days);

        $pages = PageView::where('visited_at', '<', $before)->delete();
        $clicks = ClickEvent::where('created_at', '<', $before)->delete();

        $this->info("Dihapus {$pages} page views dan {$clicks} klik (lebih tua dari {$days} hari).");

        return self::SUCCESS;
    }
}
