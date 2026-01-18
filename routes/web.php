<?php

use App\Http\Controllers\ToursController;
use Illuminate\Support\Facades\Route;

Route::fallback(function (){
    return view('app');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');;
