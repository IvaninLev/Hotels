<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Models\Tour;
use Illuminate\Http\Request;

class ToursController
{

    public function index()
    {
        $tours = Tour::paginate(PaginationEnum::PAGE_SIZE->value);
        return response()->json($tours);
    }

    public function view($id)
    {
        $tour = Tour::findOrFail($id);
        return response()->json($tour);
    }

    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        return response()->json($tour, 201);
    }

}
