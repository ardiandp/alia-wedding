<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetaSitusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_sitemap_page_lists_static_and_content_links(): void
    {
        $venue = Venue::where('is_active', true)->firstOrFail();
        $package = Package::where('is_active', true)->firstOrFail();

        $this->get(route('peta-situs'))
            ->assertOk()
            ->assertSee('Peta Situs', false)
            ->assertSee(route('contact'), false)
            ->assertSee(route('venues.show', $venue), false)
            ->assertSee($venue->name, false)
            ->assertSee(route('packages.show', $package), false)
            ->assertSee($package->name, false);
    }

    public function test_footer_links_to_the_sitemap_page(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('peta-situs'), false);
    }
}
