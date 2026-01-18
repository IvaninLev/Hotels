<?php

namespace App\Http\Resources;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Tour */
class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'days' => $this->days,
            'date' => $this->date,
            'country' => $this->country,
            'city' => $this->city,
            'price' => $this->price,
        ];
    }
}
