<?php

namespace App\Models;

use App\Helpers\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class CenterParameterValue extends Model
{
    protected static function booted()
    {
        $centerId = Common::centerId();

        //  delete Cache
        $cacheKey = "center_parameters_center_{$centerId}";
        static::saved(fn () => Cache::forget($cacheKey));
        static::deleted(fn () => Cache::forget($cacheKey));
    }

    public $fillable = ['center_parameter_id', 'value', 'order', 'updatable', 'created_at'];

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(CenterParameter::class);
    }
}
