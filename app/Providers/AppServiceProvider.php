<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro("success", function($data, $message, $statusCode) {
            return response()->json([
                'success' => true,
                'message'=> $message,
                'data' => $data
            ],$statusCode);
        });

        Response::macro("failed", function($data, $errorMessage, $statusCode) {
            return response()->json([
                'success' => false,
                'message'=> $errorMessage,
                'data' => $data
            ],$statusCode);
        });

        Response::macro("customException", function($exceptionMessage, $statusCode) {
            return response()->json([
                'status'  => false,
                'message' => $exceptionMessage
            ],$statusCode);
        });

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(2000); // change back to 2000
        });

    }
}
