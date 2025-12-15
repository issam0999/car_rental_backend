<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CenterParameterValues extends Model
{
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(CenterParameter::class);
    }
}
