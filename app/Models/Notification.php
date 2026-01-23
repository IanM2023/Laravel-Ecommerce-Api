<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Boolean;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory, SoftDeletes;

    protected $table =  'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'from_user_id',
        'details',
        'is_read',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function insertNotification($userId, $type, $fromUserID = null, $details)
    {
        return self::create([
            'user_id'       => $userId,
            'type'          => $type,
            'from_user_id'  => $fromUserID,
            'details'       => $details,
            'is_read'       => 0
        ]);
    }
}
