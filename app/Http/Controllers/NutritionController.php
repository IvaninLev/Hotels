<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\NutritionResource;
use App\Models\Nutrition;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    public function index()
    {
        $n = Nutrition::paginate(PaginationEnum::PAGE_SIZE->value);

        return NutritionResource::collection($n);
    }


    public function store(Request $request)
    {
        $n = Nutrition::create($request->all());
        return response()->json($n, 201);
    }

    public function view($id)
    {
        $n = Nutrition::findOrFail($id);
        return response()->json($n);
    }
}
