<?php

namespace App\Models;

use App\Enums\CarCategories;
use App\Enums\CarFuelTypes;
use App\Enums\CarStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'center_id',
        'brand',
        'model',
        'year',
        'category_id',
        'color',
        'plate_number',
        'seats',
        'doors',
        'transmission',
        'fuel_type',
        'mileage',
        'price_per_day',
        'price_per_week',
        'price_per_month',
        'minimum_rental_days',
        'status', 'image', 'description',
    ];

    protected $casts = [
        'status' => CarStatuses::class,
        'category' => CarCategories::class,
        'fuel_type' => CarFuelTypes::class,
    ];

    public static function getParameters(): array
    {
        return [
            'statuses' => collect(CarStatuses::cases())->map(fn ($status) => [
                'value' => $status->value,
                'title' => $status->title(),
                'color' => $status->color(),
            ])->toArray(),
            'fuelTypes' => collect(CarFuelTypes::cases())->map(fn ($fuelType) => [
                'value' => $fuelType->value,
                'title' => $fuelType->title(),
                'icon' => $fuelType->icon(),
            ])->toArray(),
            'categories' => collect(CarCategories::cases())->map(fn ($category) => [
                'value' => $category->value,
                'title' => $category->title(),
                'icon' => $category->icon(),
            ])->toArray(),
        ];
    }
}
