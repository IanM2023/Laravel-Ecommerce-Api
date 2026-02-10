<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminLog extends Model
{
    /** @use HasFactory<\Database\Factories\AdminLogFactory> */
    use HasFactory, SoftDeletes;

    protected $table =  'admin_logs';

    protected $fillable = [
        'admin_id',
        'action',
        'loggable_type',
        'loggable_id',
        'description',
        'ip_address'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function loggable()
    {
        return $this->morphTo();
    }

}
