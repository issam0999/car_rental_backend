<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    public $fillable = [
        'name',
        'description',
        'country_id',
        'city_id',
        'phone',
        'phone1',
        'email',
        'email1',
        'logo',
        'industry_id', 'subscription_type',

    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(CenterParameterValue::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(CenterPackage::class, 'subscription_type');
    }
}
