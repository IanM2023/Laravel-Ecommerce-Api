<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'address_province';

    protected $fillable = [
        'region_code',
        'province_code',
        'province_description',
        'address_province_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function regionID($code)
    {
        return Region::where('region_code', $code)->value('address_region_id');
    }
    
}
