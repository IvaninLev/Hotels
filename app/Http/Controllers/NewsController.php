<?php

namespace App\Http\Controllers;

use App\Enums\PaginationEnum;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $n = News::paginate(PaginationEnum::PAGE_SIZE->value);

        return NewsResource::collection($n);
    }


    public function store(Request $request)
    {
        $n = News::create($request->all());
        return response()->json($n, 201);
    }

    public function view($id)
    {
        $n = News::findOrFail($id);
        return response()->json($n);
    }
}
