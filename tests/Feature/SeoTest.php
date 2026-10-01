<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Event;
use App\Models\Package;
use App\Models\Setting;
use App\Models\User;
use App\Models\Venue;
use App\Support\UrlRedirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_settings_save_succeeds(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'Alia Wedding Test',
            'seo_default_title' => 'Judul Baru',
            'seo_default_description' => 'Deskripsi baru.',
            'seo_allow_indexing' => '1',
            '_token' => 'x',
            '_method' => 'PUT',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'key' => 'site_name',
            'value' => 'Alia Wedding Test',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'seo_default_title',
            'value' => 'Judul Baru',
        ]);
    }

    public function test_settings_ignore_unknown_keys(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'Asli',
            'evil_key' => 'nilai',
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('settings', ['key' => 'evil_key']);
    }

    public function test_settings_seo_fields_persist(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'seo_default_title' => 'Judul Default',
            'seo_default_description' => 'Deskripsi Default',
            'seo_google_site_verification' => 'abc123',
            'seo_allow_indexing' => '1',
            '_token' => 'x',
        ]);

        $this->assertDatabaseHas('settings', ['key' => 'seo_google_site_verification', 'value' => 'abc123']);
    }

    public function test_article_show_uses_stored_meta_title_and_description(): void
    {
        $article = Article::where('status', 'published')->firstOrFail();

        $article->update([
            'meta_title' => 'Judul SEO Artikel Kustom',
            'meta_description' => 'Deskripsi SEO artikel yang tersimpan.',
        ]);

        $response = $this->get(route('articles.show', $article));

        $response->assertOk();
        $response->assertSee('Judul SEO Artikel Kustom', false);
        $response->assertSee('Deskripsi SEO artikel yang tersimpan.', false);
    }

    public function test_event_show_uses_stored_meta_description(): void
    {
        $event = Event::where('status', 'published')->firstOrFail();

        $event->update([
            'meta_title' => 'Judul Agenda Kustom',
            'meta_description' => 'Deskripsi agenda yang tersimpan.',
        ]);

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
        $response->assertSee('Judul Agenda Kustom', false);
        $response->assertSee('Deskripsi agenda yang tersimpan.', false);
    }

    public function test_public_layout_emits_canonical_and_robots(): void
    {
        $venue = Venue::where('is_active', true)->firstOrFail();

        $response = $this->get(route('venues.show', $venue));

        $response->assertOk();
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('name="robots"', false);
    }

    public function test_og_image_is_emitted_when_present(): void
    {
        $venue = Venue::where('is_active', true)->firstOrFail();

        $venue->update(['og_image' => 'venues/og-test.jpg']);

        $response = $this->get(route('venues.show', $venue));

        $response->assertOk();
        $response->assertSee('property="og:image"', false);
        $response->assertSee('og-test.jpg', false);
    }

    public function test_draft_event_is_not_publicly_reachable(): void
    {
        $event = Event::create([
            'title' => 'Agenda Draft',
            'slug' => 'agenda-draft',
            'event_type' => 'wedding',
            'description' => 'Draft',
            'start_date' => now()->addMonth(),
            'status' => 'draft',
        ]);

        $this->get(route('events.show', $event))->assertNotFound();
    }

    public function test_cancelled_event_is_not_publicly_reachable(): void
    {
        $event = Event::create([
            'title' => 'Agenda Dibatalkan',
            'slug' => 'agenda-dibatalkan',
            'event_type' => 'wedding',
            'description' => 'Batal',
            'start_date' => now()->addMonth(),
            'status' => 'cancelled',
        ]);

        $this->get(route('events.show', $event))->assertNotFound();
    }

    public function test_inactive_venue_is_not_publicly_reachable(): void
    {
        $venue = Venue::where('is_active', true)->firstOrFail();
        $venue->update(['is_active' => false]);

        $this->get(route('venues.show', $venue))->assertNotFound();
    }

    public function test_inactive_package_is_not_publicly_reachable(): void
    {
        $package = Package::where('is_active', true)->firstOrFail();
        $package->update(['is_active' => false]);

        $this->get(route('packages.show', $package))->assertNotFound();
    }

    public function test_slug_change_records_permanent_redirect(): void
    {
        $admin = User::factory()->admin()->create();
        $article = Article::where('status', 'published')->firstOrFail();
        $oldSlug = $article->slug;

        $this->actingAs($admin)->put(route('admin.articles.update', $article), [
            'title' => 'Judul Artikel Completely Berubah',
            'body' => $article->body,
            'status' => 'published',
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('url_redirects', [
            'from_path' => '/artikel/'.$oldSlug,
            'to_path' => '/artikel/judul-artikel-completely-berubah',
            'status_code' => 301,
        ]);

        $this->get(route('articles.show', $oldSlug))
            ->assertRedirect(route('articles.show', 'judul-artikel-completely-berubah'));
    }

    public function test_redirect_hit_counter_increments(): void
    {
        UrlRedirect::record('/artikel/slug-lama-yang-dihapus', '/artikel/slug-baru');

        $this->get('/artikel/slug-lama-yang-dihapus')->assertRedirect('/artikel/slug-baru');
        $this->get('/artikel/slug-lama-yang-dihapus')->assertRedirect('/artikel/slug-baru');

        $this->assertSame(2, DB::table('url_redirects')->where('from_path', '/artikel/slug-lama-yang-dihapus')->value('hits'));
    }

    public function test_unknown_path_still_returns_not_found(): void
    {
        $this->get('/halaman-yang-tidak-ada-12345')->assertNotFound();
    }

    public function test_robots_txt_includes_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('Sitemap:', false);
        $response->assertSee('sitemap.xml', false);
    }

    public function test_robots_txt_disallows_everything_when_indexing_disabled(): void
    {
        Setting::updateOrCreate(['key' => 'seo_allow_indexing'], ['value' => '0', 'group' => 'seo']);

        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('Disallow: /', false);
        $response->assertDontSee('Sitemap:', false);
    }

    public function test_public_pages_report_noindex_when_indexing_disabled(): void
    {
        Setting::updateOrCreate(['key' => 'seo_allow_indexing'], ['value' => '0', 'group' => 'seo']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('noindex, nofollow', false);
    }

    public function test_sitemap_excludes_cancelled_events(): void
    {
        Event::create([
            'title' => 'Agenda Dibatalkan Sitemap',
            'slug' => 'agenda-batal-sitemap',
            'event_type' => 'wedding',
            'description' => 'Batal',
            'start_date' => now()->addMonth(),
            'status' => 'cancelled',
        ]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertDontSee('agenda-batal-sitemap', false);
    }

    public function test_sitemap_contains_priority_and_changefreq(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('<priority>', false)
            ->assertSee('<changefreq>', false);
    }

    public function test_admin_layout_is_noindex(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('noindex', false);
    }

    public function test_unique_slug_appends_suffix_on_collision(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.articles.store'), [
            'title' => 'Judul Artikel Unik',
            'body' => 'Isi artikel.',
            'status' => 'published',
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $this->actingAs($admin)->post(route('admin.articles.store'), [
            'title' => 'Judul Artikel Unik',
            'body' => 'Isi artikel kedua.',
            'status' => 'published',
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('articles', ['slug' => 'judul-artikel-unik']);
        $this->assertDatabaseHas('articles', ['slug' => 'judul-artikel-unik-2']);
    }

    public function test_og_image_is_saved_for_articles(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.articles.store'), [
            'title' => 'Artikel Dengan OG Image',
            'body' => 'Isi artikel.',
            'status' => 'published',
            'og_image' => 'articles/og-image.jpg',
            'canonical_url' => 'https://aliawedding.com/artikel/canonical',
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('articles', [
            'slug' => 'artikel-dengan-og-image',
            'og_image' => 'articles/og-image.jpg',
            'canonical_url' => 'https://aliawedding.com/artikel/canonical',
        ]);
    }

    public function test_seo_metadata_table_was_dropped(): void
    {
        $this->assertFalse(
            Schema::hasTable('seo_metadata'),
            'seo_metadata table should no longer exist',
        );
    }

    public function test_settings_form_shows_stored_values(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.settings.index'))
            ->assertOk()
            ->assertSee('value="Alia Wedding"', false)
            ->assertSee('name="seo_default_title"', false)
            ->assertSee('name="seo_allow_indexing"', false);
    }

    public function test_unchecking_indexing_persists_the_change(): void
    {
        $admin = User::factory()->admin()->create();

        Setting::updateOrCreate(['key' => 'seo_allow_indexing'], ['value' => '1', 'group' => 'seo']);
        setting_flush();

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => setting('site_name'),
            'seo_allow_indexing' => '0',
            '_token' => 'x',
            '_method' => 'PUT',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('settings', ['key' => 'seo_allow_indexing', 'value' => '0']);

        setting_flush();

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /', false);
    }

    public function test_venue_can_be_created_as_inactive_from_the_form(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.venues.store'), [
            'name' => 'Venue Nonaktif Baru',
            'type' => 'indoor',
            'price_type' => 'fixed',
            'is_active' => '0',
            'is_featured' => '0',
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $venue = Venue::where('slug', 'venue-nonaktif-baru')->firstOrFail();

        $this->assertFalse((bool) $venue->is_active);

        $this->get(route('venues.show', $venue))->assertNotFound();
    }

    public function test_google_site_verification_meta_is_rendered(): void
    {
        Setting::updateOrCreate(['key' => 'seo_google_site_verification'], [
            'value' => 'kode-verifikasi-abc123',
            'group' => 'seo',
        ]);

        setting_flush();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('name="google-site-verification"', false)
            ->assertSee('kode-verifikasi-abc123', false);
    }

    public function test_article_page_renders_article_json_ld(): void
    {
        $article = Article::where('status', 'published')->firstOrFail();

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee('"@type":"Article"', false)
            ->assertSee('"headline":"'.addslashes($article->title).'"', false);
    }

    public function test_event_page_renders_event_json_ld(): void
    {
        $event = Event::where('status', 'published')->firstOrFail();

        $this->get(route('events.show', $event))
            ->assertOk()
            ->assertSee('"@type":"Event"', false);
    }

    public function test_package_page_renders_offer_json_ld(): void
    {
        $package = Package::where('is_active', true)->firstOrFail();

        $this->get(route('packages.show', $package))
            ->assertOk()
            ->assertSee('"@type":"Product"', false)
            ->assertSee('"priceCurrency":"IDR"', false);
    }
}
