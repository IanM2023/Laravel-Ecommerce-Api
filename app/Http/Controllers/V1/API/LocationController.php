<?php

namespace App\Http\Controllers\V1\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LocationAddress\BaranggayResource;
use App\Http\Resources\V1\LocationAddress\CityResource;
use App\Http\Resources\V1\LocationAddress\ProvinceResource;
use App\Http\Resources\V1\LocationAddress\RegionResource;
use App\Models\Baranggay;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function regionList()
    {
        $regions = Region::all();

        return response()->json([
            'message' => 'Regions fetched successfully',
            'data' => RegionResource::collection($regions),
        ]);
    }

    public function provinceList($code) 
    {    
        $provinces = Province::where('region_code', $code)->get();

        return response()->json([
            'message' => 'Regions fetched successfully',
            'data' => ProvinceResource::collection($provinces),
        ]);
    }

    public function cityList($code)
    {
        $cities = City::where('province_code', $code)->get();

        return response()->json([
            'message' => 'Cities fetched successfully',
            'data' => CityResource::collection($cities),
        ]);
    }

    public function barangayList($code)
    {
        $brgys = Baranggay::where('city_munic_code', $code)->get();

        return response()->json([
            'message' => 'Baranggay list fetched successfully',
            'data' => BaranggayResource::collection($brgys),
        ]);
    }

}
