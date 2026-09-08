<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title', 'description', 'image', 'company_history',
    'vision', 'missions',
])]
class About extends Model
{
    protected $casts = [
        'missions' => 'array',
    ];
}
