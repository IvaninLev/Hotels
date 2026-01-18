<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitiesRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CitiesController extends City
{

    public function index(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term) {
            $results = City::where('name', 'LIKE', '%' . $search_term . '%')->paginate(10);
        } else {
            $results = City::paginate(10);
        }

        return $results;
    }
}
