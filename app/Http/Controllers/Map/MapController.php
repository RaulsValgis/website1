<?php

namespace App\Http\Controllers\Map;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Streets;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }
    


    private $url = 'https://nominatim.openstreetmap.org/';

    public function findLocation(Request $request)
    {
        $country = $request->input('country');
        $city    = $request->input('city');
        $street  = $request->input('street');

        $query   = "{$country}, {$city}, {$street}";
        $apiUrl  = "{$this->url}search?format=json&addressdetails=1&q=" . urlencode($query);

        try {
            $response = Http::get($apiUrl);
            $data     = $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch location data.'], 500);
        }

        return response()->json(['data' => $data]);
    }











    public function StreetSave(Request $request)
    {

        $request->validate([
            'country' => 'required|string|max:255',
            'city'    => 'required|string|max:255',
            'street'  => 'required|string|max:255',
        ]);

        $countryName  = $request ->input ('country');
        $cityName     = $request ->input ('city');
        $streetName   = $request ->input ('street');

        $decodedStreetName = urldecode($streetName);
        $country = Countries::firstOrCreate(['name' => $countryName]);

        $city = Cities::firstOrCreate(['city' => $cityName, 'country_id' => $country->id]);
    
        $street = new Streets();
        $street->street     = $decodedStreetName;
        $street->city_id    = $city->id;
        $street->country_id = $country->id;
        $street->save();

        return response()->json(['message' => 'Location Saved']);
    }








    
}

