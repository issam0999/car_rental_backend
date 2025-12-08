<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactConnection extends Model
{
    use HasFactory;

    public $fillable = [
        'contact_id',
        'connection_contact_id',
        'is_primary',
        'relation',
    ];

    public $casts = [
        'is_primary' => 'boolean',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function connectionContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'connection_contact_id');
    }
}
