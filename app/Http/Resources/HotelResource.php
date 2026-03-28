<?php

namespace App\Http\Resources;

use App\Models\Hotel;
use App\Models\Nutrition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Hotel
 */
class HotelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'images' => $this->images,
            'rating' => $this->rating,
            'address' => $this->address,
            'city' => $this->city->name,
            'country' => $this->country->name,
            'hotel_key' => $this->hotel_key,
            'price' => $this->price,
            'front_images' => $this->front_images,
            'main_image' => $this->main_image,
            'roomTypes' => $this->roomTypes->map(function ($room) {
                return [
                    'id' => $room->id,
                    'room_type' => $room->room_type,
                    'price_per_person' => $room->price_per_person,
                    'max_persons' => $room->max_adults + $room->max_kids,
                    'is_base' => $room->is_base,
                ];
            }),
            'nutrition' => $this->nutrition->map(function ($nut) {
                return [
                    'id' => $nut->id,
                    'name' => $nut->name,
                    'code' => $nut->code,
                    'price' => $nut->price,
                    'is_base' => $nut->is_base,
                ];
            }),
            'features' => $this->hotelFeatures?->map(function ($feature) {
                return [
                    'id' => $feature->id,
                    'name' => $feature->name,
                    'category' => $feature->category,
                    'value' => $feature->value,
                ];
            })->values(),

        ];
    }
}
