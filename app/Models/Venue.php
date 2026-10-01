<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'slug', 'description', 'capacity', 'size', 'type',
    'hero_image', 'floor_plan', 'virtual_tour_url', 'facility_note',
    'parking', 'catering', 'decoration', 'address', 'google_maps_embed',
    'starting_price', 'is_featured', 'is_active',
    'meta_title', 'meta_description', 'og_image', 'canonical_url',
])]
class Venue extends Model
{
    protected $casts = [
        'capacity' => 'integer',
        'size' => 'integer',
        'starting_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(VenueImage::class)->orderBy('sort_order');
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(VenueFacility::class)->orderBy('sort_order');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
