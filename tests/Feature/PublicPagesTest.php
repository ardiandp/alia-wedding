<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Event;
use App\Models\Package;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_renders(): void
    {
        $this->get(route('home'))->assertOk();
    }

    public function test_venue_pages_render(): void
    {
        $this->get(route('venues.index'))->assertOk();
        $venue = Venue::first();
        $this->get(route('venues.show', $venue))->assertOk();
    }

    public function test_package_pages_render(): void
    {
        $this->get(route('packages.index'))->assertOk();
        $package = Package::first();
        $this->get(route('packages.show', $package))->assertOk();
    }

    public function test_gallery_renders(): void
    {
        $this->get(route('gallery.index'))->assertOk();
    }

    public function test_events_pages_render(): void
    {
        $this->get(route('events.index'))->assertOk();
        $event = Event::first();
        if ($event) {
            $this->get(route('events.show', $event))->assertOk();
        }
    }

    public function test_articles_pages_render(): void
    {
        $this->get(route('articles.index'))->assertOk();
        $article = Article::where('status', 'published')->first();
        if ($article) {
            $this->get(route('articles.show', $article))->assertOk();
        }
    }

    public function test_company_pages_render(): void
    {
        $this->get(route('about'))->assertOk();
        $this->get(route('team'))->assertOk();
    }

    public function test_contact_page_renders(): void
    {
        $this->get(route('contact'))->assertOk();
    }

    public function test_sitemap_renders(): void
    {
        $this->get('/sitemap.xml')->assertOk();
    }

    public function test_robots_renders(): void
    {
        $this->get('/robots.txt')->assertOk();
    }

    public function test_consultation_submission_creates_lead(): void
    {
        $response = $this->post(route('contact.store'), [
            'full_name' => 'Jane Doe',
            'partner_name' => 'John Doe',
            'email' => 'jane@example.com',
            'whatsapp' => '081234567890',
            'wedding_date' => now()->addMonths(3)->format('Y-m-d'),
            'estimated_guests' => 300,
        ]);

        $response->assertRedirect(route('contact.thankyou'));

        $this->assertDatabaseHas('leads', [
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'status' => 'new',
        ]);
    }

    public function test_super_admin_can_access_dashboard(): void
    {
        $user = User::factory()->superAdmin()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();
    }
}
