<?php

namespace App\Models;

use App\Helpers\Common;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'subject', 'body', 'type_id', 'center_id'];

    protected static function booted(): void
    {
        static::addGlobalScope('center', function (Builder $builder) {
            $builder->where('center_id', Common::centerId());
        });
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CenterParameterValue::class);
    }
}
