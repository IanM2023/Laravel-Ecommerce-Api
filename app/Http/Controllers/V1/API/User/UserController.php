<?php

namespace App\Http\Controllers\V1\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\Auth\UpdateUserRequest;
use App\Http\Resources\V1\User\Address\AddressResource;
use App\Http\Resources\V1\User\Auth\UserResource;
use App\Models\Notification;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\NotificationMessagesTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthTrait, NotificationMessagesTrait;

    /**
     * Get authenticated user profile
     */
    public function me(Request $request)
    {
        return response()->success(new UserResource(auth()->user()), 'Authenticated user', 200);
    }


    public function profile()
    {
        return response()->success([
            'id'            => auth()->user()->id,
            'prefix'        => auth()->user()->prefix,
            'first_name'    => auth()->user()->first_name,
            'middle_name'   => auth()->user()->middle_name,
            'last_name'     => auth()->user()->last_name,
            'gender'        => auth()->user()->gender,
            'email'         => auth()->user()->email,
            'address'       => AddressResource::collection(auth()->user()->addresses)
        ], 'User profile', 200);
    }

    public function updateProfile(UpdateUserRequest $request, $id) 
    {
        $userRequest = $request->validated();

        $user = User::findOrFail($id);

        $user->update([
            'prefix'        => $userRequest['prefix'],
            'first_name'    => $userRequest['first_name'],
            'middle_name'   => $userRequest['middle_name'],
            'last_name'     => $userRequest['last_name'],
            'gender'        => $userRequest['gender'],
            'email'         => $userRequest['email'],
        ]);

        $message = $this->userUpdateMessage();

        Notification::insertNotification($id, 
            $message['type'], 
            $user->id, 
            $message['details']
        );

        return response()->success(
            [
                'id'            => $user->id,
                'prefix'        => $user->prefix,
                'first_name'    => $user->first_name,
                'middle_name'   => $user->middle_name,
                'last_name'     => $user->last_name,
                'gender'        => $user->gender,
                'email'         => $user->email,
            ],
        'User profile updated successfully', 200);
    }

}
