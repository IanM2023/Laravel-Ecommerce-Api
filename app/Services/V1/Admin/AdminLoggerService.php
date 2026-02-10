<?php

namespace App\Services\V1\Admin;

use App\Models\AdminLog;
use Illuminate\Database\Eloquent\Model;

class AdminLoggerService
{
    public static function log(string $action, Model $model, string $description = null)
    {
      
        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'description' => $description,
            'ip_address' => request()->ip()
        ]);
    }
}
