<?php

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\NotificationController;

Route::resource('users', UserController::class);


Route::group(['prefix' => 'v1', "middleware" => "checkToken"], function () {

    //Route for level 2 or admin
    Route::group(["middleware" => "checkLevel:1"], function () {
        
        // Route::resource('users', UserController::class);
        // Route::get('users/search', [UserController::class, "search"]);

        // Route::resource('vehicles', VehicleController::class);
        // Route::resource('records', RecordController::class)->only(["index","show","store"]);
        // Route::resource('notifications', NotificationController::class)->only(["index", "show", "store"]);;

        // Route::get('/records/request-status', [RecordController::class, 'requestStatus']);
        // Route::get('/records/number-of-orders', [RecordController::class, 'numberOfOrders']);
        // Route::get('/records/most-picked-driver', [RecordController::class, 'mostPickedDriver']);
        // Route::get('/records/most-rented-user', [RecordController::class, 'mostRentedUser']);
        // Route::get('/records/farthest-distance', [RecordController::class, 'farthestDistance']);
        // Route::get('/records/kind-of-car', [RecordController::class, 'kindOfCar']);
        // Route::get('/records/most-used-car', [RecordController::class, 'mostUsedCar']);
    });
});

