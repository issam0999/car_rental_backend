<?php

namespace App\Models;

use App\Enums\ContactStatus;
use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const CONTACT = 1;

    public const TYPE_INDIVIDUAL = 1;

    public const TYPE_ORGANIZATION = 2;

    public const TYPE_ARR = [
        self::TYPE_INDIVIDUAL => ['name' => 'Individual', 'color' => 'secondary'],
        self::TYPE_ORGANIZATION => ['name' => 'Organization', 'color' => 'primary'],
    ];

    protected $fillable = [
        'name', 'email', 'phone', 'type_id', 'date_of_birth', 'country_id', 'language_id',
        'center_id', 'status', 'address', 'city_id', 'image', 'avatar', 'website',
        'vat_number', 'tin_number', 'customer_ref_number', 'description', 'industry_id', 'channel_id',

    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => ContactStatus::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('center', function (Builder $builder) {
            $builder->where('center_id', auth()->user()->center_id);
        });
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function connections(): HasMany
    {
        return $this->hasMany(ContactConnection::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ContactCategory::class, 'contact_contact_category', 'contact_id', 'category_id');
    }

    public function salesTeam(): MorphOne
    {
        return $this->morphOne(SalesTeam::class, 'salesable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function language()
    {
        return $this->belongsTo(CenterParam::class, 'language_id');
    }

    /**
     * Get the base path for images.
     * Can be reused anywhere.
     */
    public static function getBasePath($centerId): string
    {
        return 'centers/'.$centerId.'/contacts';
    }

    /**
     * Get full public URL
     */
    public function getImageUrl($filePath)
    {
        return asset('storage/'.$filePath);
    }

    public function getType(): ?array
    {
        return self::TYPE_ARR[$this->type_id] ?? null;
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
