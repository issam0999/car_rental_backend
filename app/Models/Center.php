<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'industry',
        'status',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(CenterPackage::class);
    }
}
