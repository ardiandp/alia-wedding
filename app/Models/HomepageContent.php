<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['section', 'key', 'value'])]
class HomepageContent extends Model
{
    public static function get(string $section, string $key, mixed $default = null): mixed
    {
        $row = static::where('section', $section)->where('key', $key)->first();

        return $row?->value ?? $default;
    }

    public static function section(string $section): Collection
    {
        return static::where('section', $section)->pluck('value', 'key');
    }
}
