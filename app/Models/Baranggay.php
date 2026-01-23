<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baranggay extends Model
{
    protected $table = 'address_brgy';

    protected $fillable = [
        'address_brgy_id',
        'region_code',
        'province_code',
        'city_munic_code',
        'brgy_code',
        'brgy_description'
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

    public function cityID($code)
    {
        return City::where('city_munic_code', $code)->value('address_city_munic_id');
    }

}
