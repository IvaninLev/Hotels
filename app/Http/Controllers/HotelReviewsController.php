<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\HotelReviewResource;
use App\Models\HotelReview;
use App\Models\Review;
use Illuminate\Http\Request;

class HotelReviewsController extends Controller
{
    public function index()
    {
        $reviews = HotelReview::with('city', 'country')
            ->paginate(PaginationEnum::PAGE_SIZE->value);
        return HotelReviewResource::collection($reviews);

    }

    public function store(Request $request)
    {
        $review = HotelReview::create($request->all());
        return response()->json($review, 201);
    }

    public function view($id)
    {
        $review = HotelReview::findOrFail($id);
        return response()->json($review);
    }

}
