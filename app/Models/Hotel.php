<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Hotel extends Model
{
    use CrudTrait;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'images',
        'country_id',
        'hotel_key',
        'city_id',
        'room_type'
    ];
    protected $casts = [
        'images' => 'array'
    ];
    protected $appends = [
        'hotel_images'
    ];


    protected static function booted()
    {
        static::creating(function (Hotel $hotel) {
            $hotel->hotel_key = Str::random(10);
        });
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class);
    }

    public function hotelImages(): Attribute
    {
        $images = [];
        foreach ($this->images as $image) {
            $images[] = Storage::disk('public')->url($image);
        }
        return Attribute::make(
            get: fn() => $images
        );
    }

    public function tour():BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function hotelRoomTypes(): HasMany
    {
        return $this->hasMany(HotelRoomType::class);
    }

}
