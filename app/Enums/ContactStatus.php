<?php

namespace App\Enums;

enum ContactStatus: string
{
    case Active = 'active';
    case Dormant = 'dormant';
    case Potential = 'potential';
    case Lost = 'lost';

    public function title(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Dormant => 'Dormant',
            self::Potential => 'Potential',
            self::Lost => 'Lost',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Dormant => 'secondary',
            self::Potential => 'warning',
            self::Lost => 'danger',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
