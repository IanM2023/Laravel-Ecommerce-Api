<?php

namespace App\Http\Controllers\V1\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();

        return response()->json([
            'message' => 'fetch all users',
            'data' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    /**
     * Get authenticated user profile
     */
    public function me(Request $request)
    {
        return response()->json([
            'message' => 'Authenticated user',
            'data' => $request->user()
        ]);
    }

    /**
     * Alias or extended profile endpoint
     */
    public function user(Request $request)
    {
        return response()->json([
            'message' => 'Get user data',
            'data' => $request->user()
        ]);
    }
}
