<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tour extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tours';

    protected $fillable = [
        'name',
        'description',
        'images',
        'hotel_id',
        'country_id',
        'city_id',
        'tour_departure',
        'active_from',
        'active_to',
        'persons',
        'base_price',
        'base_persons',
        'base_price',
        'base_airport',
    ];

    protected $casts = [
        'active_from' => 'date',
        'active_to' => 'date',

        'base_price' => 'float',
        'images' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    public function baseNutrition(): BelongsTo
    {
        return $this->belongsTo(Nutrition::class);
    }

    public function nutrition(): HasMany
    {
        return $this->hasMany(Nutrition::class);
    }

    public function baseRoomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'base_room_type_id');
    }

    public function baseTourDeparture(): BelongsTo
    {
        return $this->belongsTo(TourDeparture::class, 'tour_departure');
    }

    public function returnTourDeparture(): BelongsTo
    {
        return $this->belongsTo(TourDeparture::class, 'return_tour_departure_id');
    }


    public function tourDepartures(): HasMany
    {
        return $this->hasMany(TourDeparture::class, 'tour_id', 'id');
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }


}
