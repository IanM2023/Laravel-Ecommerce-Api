<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'address_city_munic';

    protected $fillable = [
        'region_code',
        'province_code',
        'city_munic_code',
        'city_munic_description',
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

    public function provinceID($code)
    {
        return Province::where('province_code', $code)->value('address_province_id');
    }
}
