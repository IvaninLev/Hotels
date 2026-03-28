<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeparturePoint extends Model
{
    protected $table = 'departure_points';

    protected $fillable = [
        'city_id',
        'airport_name',
        'time',
        'price_diff',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

}
