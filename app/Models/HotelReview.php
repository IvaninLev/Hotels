<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_name',
        'person_second_name',
        'from_city_id',
        'main_text',
        'review_date',
        'rating_for_food',
        'rating_for_room',
        'rating_price_quality',
        'rating_for_beach',
        'hotel_id',
        'created_at',
        'updated_at',
    ];

    public function hotel():BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
