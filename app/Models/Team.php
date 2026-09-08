<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'position', 'photo', 'description',
    'instagram', 'linkedin', 'twitter', 'sort_order', 'is_active',
])]
class Team extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
