<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    public $fillable = ['imageable_id', 'imageable_type', 'path', 'name', 'order', 'is_cover'];

    public static function getImageableModels($type): ?string
    {
        return match ($type) {
            'car' => \App\Models\Car::class,
            'user' => \App\Models\User::class,
            default => null,
        };
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
