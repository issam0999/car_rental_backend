<?php

namespace App\Helpers;

class Common
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function centerId(): int
    {
        return auth()->user()->center_id;
    }
}
