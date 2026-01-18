<?php

use App\Http\Controllers\ToursController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tours', [ToursController::class, 'index']);
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::crud('city', 'CitiesCrudController');

});
Route::prefix('admin/hotel')->group(function () {
    Route::post('store', [Admin\HotelCrudController::class, 'store']);
    Route::post('{hotel}/update', [Admin\HotelCrudController::class, 'update']);
});

Route::prefix('admin/room-type')->group(function () {
    Route::get('get-room-types', [Admin\RoomTypeCrudController::class, 'getRoomTypes']);
    Route::post('store', [Admin\RoomTypeCrudController::class, 'store']);
});

Route::prefix('admin/country')->group(function () {
    Route::get('get-cities', [Admin\CountriesCrudController::class, 'getCities']);
});
