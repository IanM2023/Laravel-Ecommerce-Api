<?php

namespace App\Http\Controllers\V1\API\User\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Notification\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userID = auth()->user()->id;
        $notifications = Notification::where('user_id', $userID)
            ->latest()
            ->paginate($request->per_page);

        return NotificationResource::collection($notifications);
    }

}
