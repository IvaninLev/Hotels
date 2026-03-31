<?php

namespace App\Http\Resources;

use App\Models\TourDeparture;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TourDeparture
 */
class   TourDepartureResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->extra_price,
            'airport' => $this->airport,
            'city_name' => $this->airport->city->name,
            'country_name' => $this->airport->city->country?->name,
            'return_airport_id' => $this->return_airport_id,
            'return_airport' => $this->returnAirport,
            'return_city_name' => $this->returnAirport?->city?->name,
            'return_country_name' => $this->returnAirport?->city?->country?->name,
            'airport_id' => $this->airport_id,
            'departure_date' => $this->departure_date->toDateString(),
            'arrival_date' => $this->arrival_date->toDateString(),
            'return_date' => $this->return_date->toDateString(),
            'departure_time' => $this->departure_date->toTimeString(),
            'arrival_time' => $this->arrival_date->toTimeString(),
            'return_time' => $this->return_date->toTimeString(),
            'return_arrival_time' => $this->return_arrival_date->toTimeString(),
            'return_arrival_date' => $this->return_arrival_date->toDateString(),
            'night_count' => $this->night_count,
            'dates' =>$this->departure_date->format('d.m.Y') . '-' . $this->return_date->format('d.m.Y'),


        ];

    }
}
