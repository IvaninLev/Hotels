<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\DepartureResource;
use App\Http\Resources\TourDepartureResource;
use App\Models\TourDeparture;

class TourDepartureController extends Controller
{
    public function index()
    {
        $points = TourDeparture::with(['city_id'])
            ->paginate(PaginationEnum::PAGE_SIZE->value);
        return TourDepartureResource::collection($points);
    }

    public function view($id)
    {
        $points = TourDeparture::with(['city'])
            ->findOrFail($id);
        return response()->json($points);
    }

    public function show($id)
    {
        $points = TourDeparture::with(['city'])
            ->findOrFail($id);

        return new TourDepartureResource($points);
    }
}
