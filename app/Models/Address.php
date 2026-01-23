<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory, SoftDeletes;

    protected $table =  'addresses';

    protected $fillable = [
        'user_id',
        'type',
        'region_code',
        'region_details',
        'province_code',
        'province_details',
        'city_munic_code',
        'city_munic_details',
        'brgy_code',
        'brgy_details',
        'detailed_address',
        'is_default'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
