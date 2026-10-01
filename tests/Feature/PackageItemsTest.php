<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageItemsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->admin = User::factory()->superAdmin()->create();
    }

    public function test_admin_can_create_package_with_feature_items(): void
    {
        $this->actingAs($this->admin)->post(route('admin.packages.store'), [
            'name' => 'Paket Pernikahan Inti',
            'description' => 'Paket dasar untuk pernikahan次日.',
            'price' => 75000000,
            'price_type' => 'starting_from',
            'guest_capacity' => 150,
            'is_active' => '1',
            'is_featured' => '0',
            'items' => ['Venue', 'Catering (150 pax)', 'Sound System'],
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $package = Package::where('slug', 'paket-pernikahan-inti')->firstOrFail();

        $this->assertSame(
            ['Venue', 'Catering (150 pax)', 'Sound System'],
            $package->items()->pluck('name')->all()
        );

        $this->assertSame([0, 1, 2], $package->items()->pluck('sort_order')->all());
    }

    public function test_blank_item_rows_are_ignored_and_trimmed(): void
    {
        $this->actingAs($this->admin)->post(route('admin.packages.store'), [
            'name' => 'Paket Bersih',
            'price_type' => 'fixed',
            'is_active' => '1',
            'items' => ['  Venue  ', '', '   ', 'Dekorasi'],
            '_token' => 'x',
        ])->assertSessionHasNoErrors();

        $package = Package::where('slug', 'paket-bersih')->firstOrFail();

        $this->assertSame(['Venue', 'Dekorasi'], $package->items()->pluck('name')->all());
    }

    public function test_updating_items_replaces_the_previous_list(): void
    {
        $package = Package::where('slug', 'gold-package')->firstOrFail();
        $originalCount = $package->items()->count();

        $this->assertGreaterThan(0, $originalCount);

        $this->actingAs($this->admin)->put(route('admin.packages.update', $package), [
            'name' => $package->name,
            'price' => $package->price,
            'price_type' => $package->price_type,
            'is_active' => '1',
            'items' => ['Venue Premium', 'Dokumentasi'],
            '_token' => 'x',
            '_method' => 'PUT',
        ])->assertSessionHasNoErrors();

        $package->refresh();

        $this->assertSame(['Venue Premium', 'Dokumentasi'], $package->items()->pluck('name')->all());
        $this->assertSame(2, $package->items()->count());
    }

    public function test_updating_without_items_key_keeps_existing_items(): void
    {
        $package = Package::where('slug', 'gold-package')->firstOrFail();
        $before = $package->items()->pluck('name')->all();

        $this->actingAs($this->admin)->put(route('admin.packages.update', $package), [
            'name' => $package->name,
            'price_type' => $package->price_type,
            'is_active' => '1',
            '_token' => 'x',
            '_method' => 'PUT',
        ])->assertSessionHasNoErrors();

        $this->assertSame($before, $package->fresh()->items()->pluck('name')->all());
    }

    public function test_submitting_empty_item_list_clears_items(): void
    {
        $package = Package::where('slug', 'gold-package')->firstOrFail();

        $this->actingAs($this->admin)->put(route('admin.packages.update', $package), [
            'name' => $package->name,
            'price_type' => $package->price_type,
            'is_active' => '1',
            'items' => [],
            '_token' => 'x',
            '_method' => 'PUT',
        ])->assertSessionHasNoErrors();

        $this->assertSame(0, $package->fresh()->items()->count());
    }

    public function test_long_item_name_is_rejected(): void
    {
        $this->actingAs($this->admin)->post(route('admin.packages.store'), [
            'name' => 'Paket Validasi',
            'price_type' => 'fixed',
            'is_active' => '1',
            'items' => [str_repeat('a', 256)],
            '_token' => 'x',
        ])->assertSessionHasErrors('items.0');

        $this->assertDatabaseMissing('packages', ['slug' => 'paket-validasi']);
    }

    public function test_admin_forms_render_the_item_repeater(): void
    {
        $package = Package::where('slug', 'gold-package')->firstOrFail();

        $this->actingAs($this->admin)->get(route('admin.packages.create'))
            ->assertOk()
            ->assertSee('name="items[]"', false);

        $this->actingAs($this->admin)->get(route('admin.packages.edit', $package))
            ->assertOk()
            ->assertSee('name="items[]"', false)
            ->assertSee('Catering (400 pax)', false);
    }

    public function test_public_package_pages_render_items(): void
    {
        $package = Package::where('is_active', true)->whereHas('items')->firstOrFail();

        $this->get(route('packages.index'))
            ->assertOk()
            ->assertSee($package->items()->first()->name, false);

        $this->get(route('packages.show', $package))
            ->assertOk()
            ->assertSee($package->items()->first()->name, false);
    }

    public function test_index_labels_starting_from_prices(): void
    {
        $package = Package::create([
            'name' => 'Paket Mulai Dari',
            'slug' => 'paket-mulai-dari',
            'price' => 120000000,
            'price_type' => 'starting_from',
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->get(route('packages.index'))
            ->assertOk()
            ->assertSee('Mulai dari', false)
            ->assertSee('Rp 120.000.000', false);

        $this->assertDatabaseHas('packages', ['slug' => 'paket-mulai-dari', 'price_type' => 'starting_from']);

        $package->update(['price' => null]);

        $this->get(route('packages.index'))
            ->assertOk()
            ->assertSee('Custom', false);
    }

    public function test_venue_page_uses_package_price_from_database(): void
    {
        $package = Package::create([
            'name' => 'Paket Venue Tertaut',
            'slug' => 'paket-venue-tertaut',
            'venue_id' => Venue::where('is_active', true)->firstOrFail()->id,
            'price' => 99000000,
            'price_type' => 'fixed',
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->get(route('venues.show', $package->venue))
            ->assertOk()
            ->assertSee('Rp 99.000.000', false);
    }
}
