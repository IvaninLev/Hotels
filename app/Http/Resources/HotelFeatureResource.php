<?php

namespace App\Http\Resources;

use App\Models\HotelFeature;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin HotelFeature */

class HotelFeatureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'hotel_id' => $this->hotel_id,
            'name' => $this->name,
            'value' => $this->value,
            'category' => $this->category,
        ];
    }
}
