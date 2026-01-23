<?php

use App\Http\Controllers\V1\API\AddressController;
use App\Http\Controllers\V1\API\LocationController;
use App\Http\Controllers\V1\API\AuthController;
use App\Http\Controllers\V1\API\NotificationController;
use App\Http\Controllers\V1\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    // Auth routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        // User routes
        
        Route::get('/me', [UserController::class, 'me']);
        Route::get('/user/profile', [UserController::class, 'user']);
        Route::Resource('user', UserController::class);

        Route::resource('address', AddressController::class);
        Route::patch('/address/{id}/default', [AddressController::class, 'setDefault']);

        Route::resource('/notification', NotificationController::class);
    });

    Route::get('/regionList', [LocationController::class, 'regionList']);
    Route::get('/provinceList/{code}', [LocationController::class, 'provinceList']);
    Route::get('/cityList/{code}', [LocationController::class, 'cityList']);
    Route::get('/barangayList/{code}', [LocationController::class, 'barangayList']);
});