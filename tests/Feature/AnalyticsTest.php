<?php

namespace Tests\Feature;

use App\Models\ClickEvent;
use App\Models\PageView;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_public_page_view_is_recorded(): void
    {
        $this->get(route('home'))->assertOk();

        $this->assertDatabaseCount('page_views', 1);

        $view = PageView::firstOrFail();
        $this->assertSame('/', $view->path);
        $this->assertSame('home', $view->route_name);
        $this->assertFalse($view->is_bot);
        $this->assertSame(64, strlen($view->visitor_hash));
    }

    public function test_bots_are_flagged_but_still_recorded(): void
    {
        $this->withHeader('User-Agent', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)')
            ->get(route('home'))
            ->assertOk();

        $view = PageView::firstOrFail();
        $this->assertTrue($view->is_bot);
    }

    public function test_same_visitor_same_day_shares_a_hash(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('home'))->assertOk();

        $this->assertDatabaseCount('page_views', 2);
        $this->assertSame(1, PageView::distinct()->count('visitor_hash'));
    }

    public function test_excluded_paths_are_not_tracked(): void
    {
        $this->get('/sitemap.xml')->assertOk();
        $this->get('/robots.txt')->assertOk();
        $this->get('/login')->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public function test_authenticated_users_are_not_tracked(): void
    {
        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('home'))
            ->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public function test_disabling_analytics_stops_tracking(): void
    {
        Setting::updateOrCreate(['key' => 'analytics_enabled'], ['value' => '0', 'group' => 'analytics']);
        setting_flush();

        $this->get(route('home'))->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public function test_click_endpoint_records_a_known_label(): void
    {
        $this->postJson('/track/click', ['label' => 'whatsapp', 'path' => '/kontak', 'target' => 'https://wa.me/6281'])
            ->assertStatus(202)
            ->assertJson(['ok' => true]);

        $this->assertDatabaseHas('click_events', ['label' => 'whatsapp', 'path' => '/kontak']);
    }

    public function test_click_endpoint_coerces_unknown_labels(): void
    {
        $this->postJson('/track/click', ['label' => 'not-a-real-label'])
            ->assertStatus(202);

        $this->assertDatabaseHas('click_events', ['label' => 'cta']);
    }

    public function test_click_endpoint_requires_a_label(): void
    {
        $this->postJson('/track/click', [])->assertStatus(422);
        $this->assertDatabaseCount('click_events', 0);
    }

    public function test_click_endpoint_is_rate_limited(): void
    {
        for ($i = 0; $i < 30; $i++) {
            $this->postJson('/track/click', ['label' => 'phone'])->assertStatus(202);
        }

        $this->postJson('/track/click', ['label' => 'phone'])->assertStatus(429);
    }

    public function test_stats_page_is_admin_only(): void
    {
        $this->get(route('admin.stats.index'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->staff()->create())
            ->get(route('admin.stats.index'))
            ->assertForbidden();

        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('admin.stats.index'))
            ->assertOk()
            ->assertSee('Statistik Pengunjung', false);
    }

    public function test_stats_page_summarises_recorded_traffic(): void
    {
        PageView::create([
            'path' => '/',
            'route_name' => 'home',
            'visitor_hash' => str_repeat('a', 64),
            'ip_hash' => str_repeat('b', 64),
            'device' => 'mobile',
            'is_bot' => false,
            'visited_at' => now(),
        ]);

        ClickEvent::create([
            'label' => 'whatsapp',
            'path' => '/',
            'target' => 'https://wa.me/6281',
            'visitor_hash' => str_repeat('a', 64),
            'created_at' => now(),
        ]);

        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('admin.stats.index', ['range' => 7]))
            ->assertOk()
            ->assertSee('WhatsApp', false);
    }

    public function test_prune_command_removes_old_rows_only(): void
    {
        PageView::create([
            'path' => '/old',
            'visitor_hash' => str_repeat('c', 64),
            'is_bot' => false,
            'visited_at' => now()->subDays(200),
        ]);

        PageView::create([
            'path' => '/new',
            'visitor_hash' => str_repeat('d', 64),
            'is_bot' => false,
            'visited_at' => now(),
        ]);

        ClickEvent::create([
            'label' => 'cta',
            'path' => '/old',
            'visitor_hash' => str_repeat('c', 64),
            'created_at' => now()->subDays(200),
        ]);

        ClickEvent::create([
            'label' => 'cta',
            'path' => '/new',
            'visitor_hash' => str_repeat('d', 64),
            'created_at' => now(),
        ]);

        $this->artisan('stats:prune')->assertSuccessful();

        $this->assertDatabaseCount('page_views', 1);
        $this->assertDatabaseHas('page_views', ['path' => '/new']);
        $this->assertDatabaseCount('click_events', 1);
        $this->assertDatabaseHas('click_events', ['path' => '/new']);
    }
}
