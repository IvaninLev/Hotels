<?php

namespace App\Http\Resources;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @mixin Airport
 */


class AirportResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'city_name' => $this->city->name,
        ];
    }
}
