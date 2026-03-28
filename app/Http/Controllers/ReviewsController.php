<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::query()
            ->orderByDesc('created_at')
            ->paginate(PaginationEnum::PAGE_SIZE->value);

        return ReviewResource::collection($reviews);
    }


    public function store(Request $request)
    {
        $review = Review::create($request->all());
        return response()->json($review, 201);
    }


    public function view($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }
}
