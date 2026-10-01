<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'venue_id', 'title', 'slug', 'event_type', 'description',
    'start_date', 'end_date', 'start_time', 'end_time', 'image',
    'status', 'meta_title', 'meta_description', 'og_image', 'canonical_url',
])]
class Event extends Model
{
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
