<?php

namespace App\Http\Controllers\V1\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\DateTimeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use DateTimeTrait;

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'prefix'       => 'nullable|string|max:255',
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'gender'       => 'nullable|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'prefix'    => $validated['prefix'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'role_id' => 2,
            'status'  => 0,
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Register user successfully'
        ], 201);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->failed([], 'Unauthorized', 401);
        }
    
        $user = auth('api')->user();

        if($user->status == 1) {
            auth('api')->logout();
            return response()->failed([], 'Your account has been deactivated', 401);
        }
        // Determine role
        if ($user->role_id === 1) {
            $role = $user->role->role_name;
        } elseif ($user->role_id === 2) {
            $role = $user->role->role_name;
        } else {
            $role = 'unknown';
        }

        // Pass role to token response
        return $this->respondWithToken($token, $role);
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth()->logout();
        return response()->failed([], 'Successfully logged out', 200);
        
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Token response
     */
    protected function respondWithToken($token, $role)
    {
        $user = auth('api')->user();
    
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->secondsToYmd(JWTAuth::factory()->getTTL() * 60),
            'user' => [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'role' => $role,
            ]
        ]);
    }
}
