<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

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

        // Use only for local development to have query bench mark
        if(app()->environment('local')) 
        {
            DB::listen(function (QueryExecuted $query) {
                // SQL with placeholders
                $sql = $query->sql;
        
                // The bindings for the placeholders
                $bindings = $query->bindings;
        
                // Query execution time in milliseconds
                $time = $query->time;

                $slowThreshold = 100;

                if($time > $slowThreshold) {
                    $test = str_replace(['%', '?'], ['%%', '%s'], $sql);
                    $test = vsprintf($sql, $bindings);
                    Log::info('Slow Query Detected', ['sql' => $test, 'time_ms' => $time]);
                }
        
                // If you want the full query with bindings replaced (for logging/debugging)
                $fullSql = vsprintf(str_replace('?', '%s', $sql), array_map(function($binding) {
                    return is_numeric($binding) ? $binding : "'{$binding}'";
                }, $bindings));
        
                // Example: log the query
                Log::info("[Query Executed] {$fullSql} [Time: {$time} ms]");
            });
        }

    }
}


