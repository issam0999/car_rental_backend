<?php

namespace App\Enums;

enum CarStatuses: string
{
    case Available = 'available';
    case Rented = 'rented';
    case Maintenance = 'maintenance';
    case Unavailable = 'unavailable';

    public function title(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Rented => 'Rented',
            self::Maintenance => 'Maintenance',
            self::Unavailable => 'Unavailable',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Available => 'primary',
            self::Rented => 'success',
            self::Maintenance => 'info',
            self::Unavailable => 'warning',
        };

    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
