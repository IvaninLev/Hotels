<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\HotelFeatureResource;
use App\Models\HotelFeature;
use App\MoonShine\Resources\HotelFeatures\HotelFeaturesResource;
use Illuminate\Http\Request;

class HotelFeatureController extends Controller
{
    public function index()
    {
        $features = HotelFeature::with('hotel_id')
            ->paginate(PaginationEnum::PAGE_SIZE->value);
        return HotelFeatureResource::collection($features);

    }

    public function store(Request $request)
    {
        $features = HotelFeature::create($request->all());
        return response()->json($features, 201);
    }

    public function view($id)
    {
        $features = HotelFeature::findOrFail($id);
        return response()->json($features);
    }
}
