<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user(); // Use JWT guard
        // dd($user->role_id );
        if (!$user || $user->role_id !== User::USER) {
            throw new AuthorizationException('User access only');
        }

        return $next($request);
    }
}

