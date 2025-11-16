<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CenterPackage extends Model
{
    /**
     * Scope a query to only include active packages.
     */
    protected function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }
}
