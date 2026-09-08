<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['package_id', 'name', 'sort_order'])]
class PackageItem extends Model
{
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
