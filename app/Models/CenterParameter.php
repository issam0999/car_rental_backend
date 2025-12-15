<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CenterParameter extends Model
{
    public $fillable = ['key', 'name', 'value', 'required', 'type'];

    /*  protected static function booted(): void
     {
         static::addGlobalScope('center', function (Builder $builder) {
             $builder->where('center_id', auth()->user()->center_id);
         });
     } */

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(CenterParameterValues::class);
    }
}
