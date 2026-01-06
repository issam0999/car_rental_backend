<?php

namespace App\Enums;

enum CarCategories: string
{
    case Sedan = 'sedan';
    case SUV = 'suv';
    case Hatchback = 'hatchback';
    case Coupe = 'coupe';
    case Pickup = 'pickup';
    case Convertible = 'convertible';
    case Van = 'van';

    public function title(): string
    {
        return match ($this) {
            self::Sedan => 'Sedan',
            self::SUV => 'SUV',
            self::Hatchback => 'Hatchback',
            self::Coupe => 'Coupe',
            self::Pickup => 'Pickup',
            self::Convertible => 'Convertible',
            self::Van => 'Van',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Sedan => 'tabler-car',
            self::SUV => 'tabler-car-suv',
            self::Hatchback => 'tabler-car-garage',
            self::Coupe => 'tabler-car',
            self::Pickup => 'tabler-tir',
            self::Convertible => 'tabler-car',
            self::Van => 'tabler-truck',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
