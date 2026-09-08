<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'customer_name', 'partner_name', 'photo', 'rating', 'testimonial',
    'wedding_date', 'venue_id', 'is_featured', 'is_active',
])]
class Testimonial extends Model
{
    protected $casts = [
        'rating' => 'integer',
        'wedding_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
