<?php

namespace App\Models;

use App\Helpers\Common;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class CenterParameter extends Model
{
    public $fillable = ['key', 'name', 'value', 'required', 'type'];

    protected static function booted(): void
    {
        $centerId = Common::centerId();

        static::addGlobalScope('center', function (Builder $builder) use ($centerId) {
            $builder->where('center_id', $centerId);
        });

        //  delete Cache
        $cacheKey = "center_parameters_center_{$centerId}";
        static::saved(fn () => Cache::forget($cacheKey));
        static::deleted(fn () => Cache::forget($cacheKey));
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(CenterParameterValues::class);
    }
}
