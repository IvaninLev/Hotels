<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;

class   HotelsController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with(['country', 'city', 'roomTypes', 'hotelFeatures','nutrition'])
            ->paginate(PaginationEnum::PAGE_SIZE->value);
        return HotelResource::collection($hotels);
    }

    public function view($id)
    {
        $hotel = Hotel::with(['country', 'city', 'roomTypes', 'hotelFeatures','nutrition'])
            ->findOrFail($id);
        return response()->json($hotel);
    }

    public function show($id)
    {
        $hotel = Hotel::with(['country', 'city', 'roomTypes', 'hotelFeatures','nutrition'])
            ->findOrFail($id);

        return new HotelResource($hotel);
    }
}
