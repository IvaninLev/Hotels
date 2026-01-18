<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelRoomType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'beds',
        'hotel_id',
        'room_type_id',
        'area',
        'price',
        'total_rooms',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
