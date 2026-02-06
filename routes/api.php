<?php

use App\Http\Controllers\V1\API\Admin\Category\CategoryController;
use App\Http\Controllers\V1\API\Admin\Inventory\InventoryController;
use App\Http\Controllers\V1\API\Admin\Notification\NotificationController as AdminNotificationController;
use App\Http\Controllers\V1\API\Admin\Product\ProductController;
use App\Http\Controllers\V1\API\Admin\Product\ProductVariantController;
use App\Http\Controllers\V1\API\Admin\UserAdmin\UserController as AdminUserController;
use App\Http\Controllers\V1\API\User\Address\AddressController;
use App\Http\Controllers\V1\API\LocationController;
use App\Http\Controllers\V1\API\AuthController;
use App\Http\Controllers\V1\API\User\Notification\NotificationController;
use App\Http\Controllers\V1\API\User\UserController;
use App\Models\ProductVariant;
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

        Route::prefix('user')->middleware(['user', 'inactive'])->group(function () {
        // User routes
            Route::get('/me', [UserController::class, 'me']);
            Route::get('/profile', [UserController::class, 'profile']);
            Route::patch('/profile/{id}', [UserController::class, 'updateProfile']);
            Route::resource('address', AddressController::class);
            Route::patch('/address/{id}/default', [AddressController::class, 'setDefault']);
            Route::resource('notification', NotificationController::class);
        });

       
        Route::prefix('admin')->middleware(['admin', 'inactive'])->group( function() {
            Route::resource('user', AdminUserController::class);
            Route::resource('notification', AdminNotificationController::class);
            Route::resource('category', CategoryController::class);
            Route::resource('product', ProductController::class);
            Route::resource('product-variant', ProductVariantController::class);
            Route::resource('inventory', InventoryController::class);
        });
    
    });


    Route::get('/regionList', [LocationController::class, 'regionList']);
    Route::get('/provinceList/{code}', [LocationController::class, 'provinceList']);
    Route::get('/cityList/{code}', [LocationController::class, 'cityList']);
    Route::get('/barangayList/{code}', [LocationController::class, 'barangayList']);
});