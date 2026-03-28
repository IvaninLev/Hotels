<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Hotel extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'hotel_key',
        'name',
        'price',
        'description',
        'images',
        'rating',
        'address',
        'city_id',
        'features',
    ];
    protected $casts = [
        'images' => 'array',
        'features' => 'array',
    ];


    protected static function booted()
    {
        static::creating(function (Hotel $hotel) {
            $hotel->hotel_key = Str::random(10);
        });
    }

    public function roomTypes(): HasMany
    {
        return $this->hasMany(RoomType::class, 'hotel_id', 'id');
    }

    public function nutrition(): HasMany
    {
        return $this->hasMany(Nutrition::class, 'hotel_id', 'id');
    }

    public function hotelFeatures(): HasMany
    {
        return $this->hasMany(HotelFeature::class, 'hotel_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function mainImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $images = $this->images;

                if (is_array($images)) {
                    $first = $images[0] ?? null;
                } elseif (is_string($images)) {
                    $decoded = json_decode($images, true);
                    $first = $decoded[0] ?? null;
                } else {
                    $first = null;
                }

                return $first ? Storage::url($first) : null;
            }
        );
    }

    public function frontImages(): Attribute
    {
        return Attribute::make(
            get: function () {
                $images = $this->images;
                if (is_array($images)) {
                    return array_map(fn($img) => Storage::url($img), $images);
                }

                if (is_string($images)) {
                    $decoded = json_decode($images, true) ?? [];
                    return array_map(fn($img) => Storage::url($img), $decoded);
                }

                return [];
            }
        );
    }

}
