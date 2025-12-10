<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    protected $fillable = [
        'name', 'number', 'type_id', 'issue_date', 'expiry_date',
        'path',
        'mime_type',
        'size', 'documentable_type', 'documentable_id', 'external_link',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
