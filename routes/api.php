<?php

use App\Http\Controllers\DeparturePointController;
use App\Http\Controllers\HotelFeatureController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\HotelReviewsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ToursController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tours', [ToursController::class, 'index']);
Route::get('/tours/filters', [ToursController::class, 'filtered']);
Route::get('/tours/search', [ToursController::class, 'founded']);
Route::get('/tours/{params}', [ToursController::class, 'view']);


Route::get('/hotels', [HotelsController::class, 'index']);
Route::get('/hotels/{id}', [HotelsController::class, 'view']);

Route::get('/departure', [DeparturePointController::class, 'index']);

Route::get('/news', [NewsController::class,'index']);

Route::get('/reviews', [ReviewsController::class, 'index']);
Route::post('/reviews', [ReviewsController::class, 'store']);

Route::get('/hotelFeatures', [HotelFeatureController::class, 'index']);
Route::get('/hotelNutrition', [NutritionController::class, 'index']);
