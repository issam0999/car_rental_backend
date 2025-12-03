<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SalesTeam extends Model
{
    protected $fillable = [
        'center_id',
        'percentage_onsales',
        'amount_onsales',
    ];

    public function salesable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function getParent($id)
    {
        $sales = SalesTeam::find($id);

        return $sales->salesable;
    }
}
