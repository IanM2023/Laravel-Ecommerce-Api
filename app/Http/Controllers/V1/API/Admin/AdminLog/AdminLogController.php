<?php

namespace App\Http\Controllers\V1\API\Admin\AdminLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\AdminLog\AdminLogResource;
use App\Models\AdminLog;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $adminLog = AdminLog::latest()->paginate($request->per_pag ?? 15);
        return AdminLogResource::collection($adminLog);
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminLog $adminLog)
    {
        return response()->success(new AdminLogResource($adminLog), 'Log activity show', 200);
    }

}
