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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function regionList()
    {
        $regions = Region::all();
        
        return response()->success(RegionResource::collection($regions), 'Regions fetched successfully' , 200);
    }

    public function provinceList($code) 
    {    
        $provinces = Province::where('region_code', $code)->get();

        $this->emptyCode($provinces);

        return response()->success(ProvinceResource::collection($provinces), 'Province fetched successfully' , 200);
    }

    public function cityList($code)
    {
        $cities = City::where('province_code', $code)->get();

        $this->emptyCode($cities);

        return response()->success(CityResource::collection($cities), 'Cities fetched successfully' , 200);
    }

    public function barangayList($code)
    {
        $brgys = Baranggay::where('city_munic_code', $code)->get();
        
        $this->emptyCode($brgys);
        
        return response()->success(BaranggayResource::collection($brgys), 'Baranggay list fetched successfully' , 200);
    }

    private function emptyCode($code)
    {
        if($code->isEmpty())
        {
            abort(404);
        }
    }
}
