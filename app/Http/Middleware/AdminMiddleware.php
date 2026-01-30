<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user(); // Use JWT guard

        if (!$user || $user->role_id !== User::ADMIN) {
            throw new AuthorizationException('Admin access only');
        }

        return $next($request);
    }
}

