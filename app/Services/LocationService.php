<?php

namespace App\Services;

use App\Models\District;
use App\Models\Zila;

class LocationService
{

    public static function districtWiseZila()
    {
        $districts = District::with(['zilas:id,name,district_id'])
            ->get(['id', 'name']);
        return $districts;
    }

    public static function zilaWiseUpozila()
    {
        $zilas = Zila::with(['upozilas:id,name,zila_id'])
            ->get(['id', 'name', 'district_id']);
        return $zilas;
    }
}
