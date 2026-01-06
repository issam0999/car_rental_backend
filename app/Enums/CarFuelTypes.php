<?php

namespace App\Enums;

enum CarFuelTypes: string
{
    case Gasoline = 'gasoline';
    case Diesel = 'diesel';
    case Electric = 'electric';
    case Hybrid = 'hybrid';

    public function title(): string
    {
        return match ($this) {
            self::Gasoline => 'Gasoline',
            self::Diesel => 'Diesel',
            self::Electric => 'Electric',
            self::Hybrid => 'Hybrid',

        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Gasoline => 'tabler-gas-station',
            self::Diesel => 'tabler-engine',
            self::Electric => 'tabler-bolt',
            self::Hybrid => 'tabler-leaf',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
