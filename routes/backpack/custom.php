<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('countries', Admin\CountriesCrudController::class);
    Route::crud('cities', Admin\CitiesCrudController::class);
    Route::crud('airport', Admin\AirportCrudController::class);

    Route::prefix('hotel')->group(function () {
        Route::crud('', Admin\HotelCrudController::class);
        Route::get('create', [Admin\HotelCrudController::class, 'create'])->name('hotel.create');
        Route::get('{hotel}/edit', [Admin\HotelCrudController::class, 'edit'])->name('hotel.edit');
        Route::post('store', [Admin\HotelCrudController::class, 'store'])->name('hotel.store');
        Route::post('{hotel}/update', [Admin\HotelCrudController::class, 'update'])->name('hotel.update');
    });

    Route::prefix('hotel')->group(function () {
        Route::crud('edit', Admin\HotelCrudController::class,'hotel.edit');
        Route::post('store', [Admin\HotelCrudController::class, 'store'])->name('hotel.store');
    });
    Route::prefix('bus')->group(function () {
        Route::get('create', [\App\Http\Controllers\BusController::class, 'create'])->name('bus.create');
        Route::get('index', [\App\Http\Controllers\BusController::class, 'index'])->name('bus.index');
    });


    Route::crud('tour', Admin\TourCrudController::class);
    Route::get('cities-list', [Admin\CitiesCrudController::class, 'getCities']);
    Route::crud('room-type', 'RoomTypeCrudController');
    Route::crud('room-service', 'RoomServiceCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
