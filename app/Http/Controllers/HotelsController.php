<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelsController extends Model
{

    public function index()
    {
        return response()->json(Tour::all());
    }

    public function show($id)
    {
        $tour = Tour::with('hotels')->findOrFail($id);

        return response()->json([
            'tour'=>$tour,
            'total_price'=>$tour->total_price,
            'hotels'=>$tour->hotels
        ]);
    }
}
