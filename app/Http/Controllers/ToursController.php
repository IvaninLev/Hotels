<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Services\TourService;
use Illuminate\Http\Request;

class ToursController extends Controller
{

    public function index(Request $request, TourService $service)
    {
        $query = Tour::with([
            'hotel',
            'tourDepartures',
            'tourDepartures.airport.city.country',
            'tourDepartures.returnAirport.city.country',
            'baseTourDeparture.airport',
            'baseTourDeparture.returnAirport',
        ]);
        $service->applySorting($query, $request->get('sort'));
        $tours = $query->paginate(PaginationEnum::PAGE_SIZE->value);
        return TourResource::collection($tours);
    }

    public function view($id)
    {
        $tour = Tour::with([
            'hotel',
            'tourDepartures',
            'tourDepartures.airport.city.country',
            'tourDepartures.returnAirport.city.country',
            'baseTourDeparture.airport',
            'baseTourDeparture.returnAirport',
        ])->findOrFail($id);
        return new TourResource($tour);
    }

    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        return response()->json($tour, 201);
    }

    public function searched(Request $request, TourService $service)
    {
        return TourResource::collection($service->searched($request));
    }

    public function filtered(Request $request, TourService $service)
    {
        return TourResource::collection($service->filtered($request));
    }

}
