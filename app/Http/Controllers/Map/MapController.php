<?php

namespace App\Http\Controllers\Map;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Streets;

class MapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }
    
    public function StreetSave(Request $request)
    {

        $request->validate([
            'country' => 'required|string|max:255',
            'city'    => 'required|string|max:255',
            'street'  => 'required|string|max:255',
        ]);

        $countryName = $request->input('country');
        $cityName = $request->input('city');
        $streetName = $request->input('street');

        $decodedStreetName = urldecode($streetName);
        $country = Countries::firstOrCreate(['name' => $countryName]);

        $city = Cities::firstOrCreate(['city' => $cityName, 'country_id' => $country->id]);
    
        $street = new Streets();
        $street->street = $decodedStreetName;
        $street->city_id = $city->id;
        $street->country_id = $country->id;
        $street->save();

        return response()->json(['message' => 'Location saved successfully']);
    }
}
