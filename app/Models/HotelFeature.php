<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelFeature extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
        'name',
        'category',
        'value'
    ];

    public function hotel():BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

}
