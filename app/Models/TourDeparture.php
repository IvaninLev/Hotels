<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourDeparture extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tour_departures';

    protected $fillable = [
        'extra_price',
        'airport_id',
        'departure_date',
        'arrival_date',
        'return_airport_id',
        'tour_id',
        'night_count',
        'return_date',
        'return_arrival_date',
    ];

    protected $casts = [
        'departure_date' => 'datetime',
        'arrival_date' => 'datetime',
        'return_date' => 'datetime',
        'return_arrival_date' => 'datetime',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }

    public function returnAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'return_airport_id');
    }
}
