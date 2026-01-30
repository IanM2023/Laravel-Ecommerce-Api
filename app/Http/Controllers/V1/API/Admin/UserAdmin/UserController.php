<?php

namespace App\Http\Controllers\V1\API\Admin\UserAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\Auth\UserResource;
use App\Models\User;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
  
        $users = User::where('role_id', $this->getUserRoleId())
                    ->where('status', 0)
                    ->latest()
                    ->paginate($request->per_page);
    
        return UserResource::collection($users);
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

    public function deactivateUser()
    {
        
    }
}
