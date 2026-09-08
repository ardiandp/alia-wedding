<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\Lead;
use App\Models\Package;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::factory()->superAdmin()->create();
    }

    public function test_dashboard_renders(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_venues_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.venues.index'))->assertOk();
        $this->get(route('admin.venues.create'))->assertOk();
        $venue = Venue::first();
        $this->get(route('admin.venues.edit', $venue))->assertOk();
    }

    public function test_packages_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.packages.index'))->assertOk();
        $this->get(route('admin.packages.create'))->assertOk();
        $package = Package::first();
        $this->get(route('admin.packages.edit', $package))->assertOk();
    }

    public function test_events_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.events.index'))->assertOk();
        $this->get(route('admin.events.create'))->assertOk();
        $event = Event::first();
        $this->get(route('admin.events.edit', $event))->assertOk();
    }

    public function test_galleries_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.galleries.index'))->assertOk();
        $this->get(route('admin.galleries.create'))->assertOk();
        $gallery = Gallery::first();
        if ($gallery) {
            $this->get(route('admin.galleries.edit', $gallery))->assertOk();
        }
    }

    public function test_testimonials_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.testimonials.index'))->assertOk();
        $this->get(route('admin.testimonials.create'))->assertOk();
        $testimonial = Testimonial::first();
        if ($testimonial) {
            $this->get(route('admin.testimonials.edit', $testimonial))->assertOk();
        }
    }

    public function test_teams_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.teams.index'))->assertOk();
        $this->get(route('admin.teams.create'))->assertOk();
        $team = Team::first();
        if ($team) {
            $this->get(route('admin.teams.edit', $team))->assertOk();
        }
    }

    public function test_services_admin_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.services.index'))->assertOk();
        $this->get(route('admin.services.create'))->assertOk();
        $service = Service::first();
        if ($service) {
            $this->get(route('admin.services.edit', $service))->assertOk();
        }
    }

    public function test_crm_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.leads.index'))->assertOk();
        $lead = Lead::first();
        if ($lead) {
            $this->get(route('admin.leads.show', $lead))->assertOk();
        }
    }

    public function test_content_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.about.edit'))->assertOk();
        $this->get(route('admin.homepage.edit'))->assertOk();
        $this->get(route('admin.settings.index'))->assertOk();
    }

    public function test_media_library_pages_render(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.media.index'))->assertOk();

        $media = Media::first();
        if ($media) {
            $this->withHeader('X-Requested-With', 'XMLHttpRequest')
                ->get(route('admin.media.browser'))
                ->assertOk()
                ->assertSee(media_relative_path($media));
        }
    }

    public function test_staff_cannot_access_admin_only_pages(): void
    {
        $staff = User::factory()->staff()->create();
        $this->actingAs($staff)->get(route('admin.venues.index'))->assertForbidden();
    }
}
