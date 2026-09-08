<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['venue_id', 'image', 'caption', 'sort_order'])]
class VenueImage extends Model
{
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
