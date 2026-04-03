<?php

namespace App\Services;

use App\Enums\PaginationEnum;
use App\Models\Hotel;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourService
{
    private function getBaseQuery()
    {
        return Tour::with([
            'hotel',
            'tourDepartures',
            'tourDepartures.airport.city.country',
            'tourDepartures.returnAirport.city.country',
        ]);

    }

    public function applySorting($query, ?string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('base_price'),
            'rating_desc' => $query->orderByDesc(
                Hotel::select('rating')->whereColumn('hotels.id', 'tours.hotel_id')
            ),
            'latest' => $query->orderByDesc('active_from'),
            default => $query->orderByDesc('id'),
        };
    }

    public function filtered(Request $request)
    {
        $query = $this->getBaseQuery();

        $query->when($request->input('searchQuery'), function ($query, $searchQ) {
            $query->where('name', 'like', '%' . $searchQ . '%');
        });

        $query->when($request->input('toPlace'), function ($query, $searchQ) {
            $query->whereHas('city', function ($query) use ($searchQ) {
                $query->where('name', 'like', '%' . $searchQ . '%');
            })->orWherehas('country', function ($query) use ($searchQ) {
                $query->where('name', 'like', '%' . $searchQ . '%');
            });
        });

        $query->when($request->input('flightDate'), function ($query, $date) {
            $query->whereHas('tourDepartures', function ($q) use ($date) {
                $q->whereDate('departure_date', $date);
            });
        });

        $season = $request->input('season');
        $seasonMonths = match ($season) {
            'winter' => [12, 1, 2],
            'spring' => [3, 4, 5],
            'summer' => [6, 7, 8],
            'autumn' => [9, 10, 11],
            default => [],
        };
        if (!empty($seasonMonths)) {
            $query->where(function ($q) use ($seasonMonths) {
                $q->where(DB::raw('MONTH(active_from)'), $seasonMonths);
            });
        }

        $query->when($request->input('minRating'), function ($q, $rating) {
            if (is_numeric($rating)) {
                $q->whereHas('hotel', function ($q) use ($rating) {
                    $q->where('rating', '>=', $rating);
                });
            }

        });
        $query->when($request->input('duration'), function ($q, $duration) {
            if (is_array($duration) && count($duration) >= 2) {
                $min = (int)$duration[0];
                $max = (int)$duration[1];
                $q->whereHas('tourDepartures', function ($q) use ($min, $max) {
                    $q->whereBetween('night_count', [$min, $max]);
                });
            }
        });

        $query->when($request->input('foodType'), function ($q, $code) {
            $q->where(function ($q) use ($code) {
                $q->WhereHas('hotel.nutrition', fn($q) => $q->where('code', $code));
            });
        });


        $query->when($request->input('amenities'), function ($q, $amenities) {
            if (is_array($amenities) && count($amenities) > 0) {
                $q->whereHas('hotel.features', function ($q) use ($amenities) {
                    $q->whereIn('name', $amenities);
                });
            }
        });

        $this->applySorting($query, $request->input('sort') ?? null);

        return $query->paginate(PaginationEnum::PAGE_SIZE->value);
    }

    public function searched(Request $request)
    {
        $query = $this->getBaseQuery();

        // откуда
//        $query->when($request->from, function ($q, $from) {
//            $q->whereHas('tourDepartures.airport.city', function ($q) use ($from) {
//                $q->where('name', 'like', "%{$from}%");
//            });
//        });

        // куда
        $query->when($request->input('toPlace'), function ($query, $searchQ) {
            $query->whereHas('city', function ($query) use ($searchQ) {
                $query->where('name', 'like', '%' . $searchQ . '%');
            })->orWherehas('country', function ($query) use ($searchQ) {
                $query->where('name', 'like', '%' . $searchQ . '%');
            });
        });

        $query->when($request->input('flightDate'), function ($q, $date) {
            $q->where(function ($q) use ($date) {
                $q->whereDate('active_from', '<=', $date)
                    ->whereDate('active_to', '>=', $date);
            });
        });

        $query->when($request->input('duration'), function ($q, $duration) {
            if (str_contains($duration, '-')) {
                [$min, $max] = explode('-', $duration);
                $q->whereHas('tourDepartures', function ($q) use ($min, $max) {
                    $q->whereBetween('night_count', [(int)$min, (int)$max]);
                });
            } else {
                $q->whereHas('tourDepartures', function ($q) use ($duration) {
                    $q->where('night_count', '>=', (int)$duration);
                });
            }
        });

        $persons = $request->input('tourists') ?? $request->input('persons');
        if ($persons !== null && $persons !== '') {
            $query->where(function ($q) use ($persons) {
                $q->where('persons', '>=', (int)$persons);
            });
        }

        $this->applySorting($query, $data['sort'] ?? null);

        return $query->paginate(PaginationEnum::PAGE_SIZE->value);
    }


}
