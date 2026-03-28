<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class ToursController extends Controller
{

    public function index()
    {
        $tours = Tour::with([
            'hotel',
            'tourDepartures',
            'tourDepartures.airport.city.country',
            'tourDepartures.returnAirport.city.country',
            'baseTourDeparture.airport',
            'baseTourDeparture.returnAirport',
        ])
            ->paginate(PaginationEnum::PAGE_SIZE->value);
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

    public function filtered(Request $request)
    {

        $query = Tour::with([
            'hotel',
            'tourDepartures',
            'tourDepartures.airport.city.country',
            'tourDepartures.returnAirport.city.country',
        ]);

        $query->when($request->searchQuery, function ($query, $searchQ) {
            $query->where('name', 'like', '%' . $searchQ . '%');
        });

        $query->when($request->toPlace, function ($query, $searchQ) {
            $query->whereHas('city', function ($query) use ($searchQ) {
                $query->where('name', 'like', '%' . $searchQ . '%');
            })->orWherehas('country', function ($query) use ($searchQ) {
                $query->where('name', 'like', '%' . $searchQ . '%');
            });
        });

        $season = $request->offerType ?? $request->season;
        $seasonMonths = match ($season) {
            'winter' => [12, 1, 2],
            'spring' => [3, 4, 5],
            'summer' => [6, 7, 8],
            'autumn' => [9, 10, 11],
            default => [],
        };
        if (!empty($seasonMonths)) {
            $query->where(function ($q) use ($seasonMonths) {
                $q->whereHas('tourDepartures', function ($q) use ($seasonMonths) {
                    $q->where(function ($q) use ($seasonMonths) {
                        foreach ($seasonMonths as $month) {
                            $q->orWhereIn('departure_date', $month);
                        }
                    });
                })->orWhere(function ($q) use ($seasonMonths) {
                    $q->whereNotNull('active_from')
                        ->whereNotNull('active_to')
                        ->where(function ($q) use ($seasonMonths) {
                            foreach ($seasonMonths as $month) {
                                $q->orWhereIn('active_from', $month)
                                    ->orWhereIn('active_to', $month);
                            }
                        });
                });
            });
        }

        $query->when($request->minRating, function ($q, $rating) {
            if (is_numeric($rating)) {
                $q->whereHas('hotel', function ($q) use ($rating) {
                    $q->where('rating', '>=', $rating);
                });
            }

        });
        $query->when($request->duration, function ($q, $duration) {
            if (is_array($duration) && count($duration) >= 2) {
                $min = (int)$duration[0];
                $max = (int)$duration[1];
                $q->whereHas('tourDepartures', function ($q) use ($min, $max) {
                    $q->whereBetween('night_count', [$min, $max]);
                });
            }
        });

        $query->when($request->foodType, function ($q, $code) {
            $q->where(function ($q) use ($code) {
                $q->whereHas('baseNutrition', fn($q) => $q->where('code', $code))
                    ->orWhereHas('hotel.nutrition', fn($q) => $q->where('code', $code));
            });
        });


        $query->when($request->amenities, function ($q, $amenities) {
            if (is_array($amenities) && count($amenities) > 0) {
                $q->whereHas('hotel.features', function ($q) use ($amenities) {
                    $q->whereIn('name', $amenities);
                });
            }
        });

        $tours = $query->paginate(PaginationEnum::PAGE_SIZE->value);

        return TourResource::collection($tours);
    }

    public function founded(Request $request)
    {
        $query = Tour::query()->with([
            'hotel',
            'tourDepartures',
            'tourDepartures.airport.city.country',
            'tourDepartures.returnAirport.city.country',
        ]);

        // откуда
        $query->when($request->from, function ($q, $from) {
            $q->whereHas('baseTourDeparture.airport.city', function ($q) use ($from) {
                $q->where('name', 'like', "%{$from}%");
            });
        });

        // куда
        $query->when($request->toPlace, function ($q, $to) {
            $q->whereHas('city', function ($q) use ($to) {
                $q->where('name', 'like', "%{$to}%");
            });
        });

        $query->when($request->flightDate, function ($q, $date) {
            $q->whereHas('tourDepartures', function ($q) use ($date) {
                $q->whereDate('departure_date', '>=', $date);
            });
        });

        $query->when($request->duration, function ($q, $duration) {
            $q->whereHas('tourDepartures', function ($q) use ($duration) {
                $q->where('night_count', (int)$duration);
            });
        });

        $persons = $request->tourists ?? $request->persons;
        if ($persons !== null && $persons !== '') {
            $query->where(function ($q) use ($persons) {
                $q->where('base_persons', '>=', (int)$persons)
                    ->orWhere('persons', '>=', (int)$persons);
            });
        }

        $tours = $query->paginate(PaginationEnum::PAGE_SIZE->value);
        return TourResource::collection($tours);
    }

}
