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
        'location',
        'phone',
        'phone1',
        'email',
        'email1',
        'logo',
        'industry', 'subscription_type',
        'status',

    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(CenterPackage::class, 'subscription_type');
    }
}
