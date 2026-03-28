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
            'departure_date' => $this->departure_date,
            'arrival_date' => $this->arrival_date,
            'return_date' => $this->return_date,
            'return_arrival_date' => $this->return_arrival_date,
            'night_count' => $this->night_count,
            'dates' =>$this->departure_date->format('d.m.Y') . '-' . $this->return_date->format('d.m.Y'),
            'debug_dep' => $this->departure_date->toDateString(), // добавь это


        ];

    }
}
