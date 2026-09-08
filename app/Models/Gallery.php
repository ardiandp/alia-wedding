<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title', 'category', 'image', 'description', 'sort_order', 'is_active',
])]
class Gallery extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const CATEGORIES = [
        'venue', 'wedding', 'decoration', 'reception',
        'bride_groom', 'table_setting', 'garden', 'real_wedding',
    ];
}
