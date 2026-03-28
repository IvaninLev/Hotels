<?php

namespace App\Http\Resources;

use App\Models\HotelReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/** @mixin HotelReview */
class HotelReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'person_name' => $this->person_name,
          'person_second_name' => $this->person_second_name,
          'from_city_id' => $this->from_city_id,
          'main_text' => $this->main_text,
          'review_date' => $this->review_date,
          'rating_for_food' => $this->rating_for_food,
          'rating_for_room' => $this->rating_for_room,
          'rating_price_quality' => $this->rating_price_quality,
          'rating_for_beach' => $this->rating_for_beach,
          'hotel_id' => $this->hotel_id,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ];
    }

}
