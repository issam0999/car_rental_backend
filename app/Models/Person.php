<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 1;

    public const STATUS_DELETED = 0;

    public const TYPE_CONTACT = 1;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type_id',
        'date_of_birth',
        'country_id',
        'center_id',
        'status',
        'address',
        'city_id',
        'image',
        'avatar',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Get the base path for images.
     * Can be reused anywhere.
     */
    public static function getBasePath($centerId): string
    {
        return 'centers/'.$centerId.'/persons';
    }

    /**
     * Get full public URL
     */
    public function getImageUrl($filePath)
    {
        return asset('storage/'.$filePath);
    }

    public function saveImage($image)
    {
        $basePath = self::getBasePath($this->center_id);

        // Delete old image if it exists
        if ($this->image) {
            FileHelper::deleteImage($this->image);
        }

        return FileHelper::saveBase64Image($image, $basePath);
    }
}
