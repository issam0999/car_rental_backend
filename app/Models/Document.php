<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name', 'number', 'type_id', 'issue_date', 'expiry_date',
        'path',
        'mime_type',
        'size',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}
