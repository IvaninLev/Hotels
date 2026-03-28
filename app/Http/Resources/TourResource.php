<?php

namespace App\Http\Resources;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TourDepartureResource;

/** @mixin Tour */
class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hasDates = $this->active_from && $this->active_to;
        return [
            'id' => $this->id,

            'name' => $this->name,

            'image' => $this->images
                ? Storage::url($this->images[0])
                : null,


            'country' => $this->country?->name,
            'city' => $this->city?->name,

            'date' => optional($this->tourDepartures->first()?->departure_date)->format('d.m.Y')
                . '-' . optional($this->tourDepartures->first()?->return_date)->format('d.m.Y'),
            'season' => $this->tourDepartures->first()?->departure_date->format('d.m.Y'),


            'days' => $hasDates
                ? $this->active_from->diffInDays($this->active_to)
                : null,

            'hotel' => HotelResource::make($this->hotel),

            'persons' => $this->persons,
            'base_price' => (int)$this->base_price,

            'tour_departures' => TourDepartureResource::collection($this->tourDepartures),

        ];
    }
}
