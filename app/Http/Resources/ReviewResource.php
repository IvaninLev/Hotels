<?php

namespace App\Http\Resources;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Review */

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rating' => $this->rating,
            'avatar' => $this->avatar,
            'was_in_hotel' => $this->was_in_hotel,
            'main_text' => $this->main_text,
            'flight_to' => $this->flight_to,
            'person_from' => $this->person_from,
            'flight_date' => $this->flight_date,
        ];
    }
}
