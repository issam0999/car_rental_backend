<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    protected $fillable = [
        'name', 'number', 'type_id', 'issue_date', 'expiry_date', 'note',
        'path', 'reminder',
        'mime_type',
        'size', 'documentable_type', 'documentable_id', 'external_link',
    ];

    public const STATUS_ARR = [
        ['value' => 1, 'title' => 'Active', 'color' => 'success'],
        ['value' => 2, 'title' => 'Expiring', 'color' => 'warning'],
        ['value' => 3, 'title' => 'Expired', 'color' => 'error'],
    ];

    public $casts = ['reminder' => 'boolean'];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CenterParameterValue::class);
    }
}
