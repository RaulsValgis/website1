<?php

namespace App\Http\Controllers\Cities;

use App\Models\User;
use App\Models\Cities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;



class CitiesController extends Controller
{

    public function index()
    {
        $Population = cities::orderBy('population')->get();
 
        return view('cities.index', compact('Population'));
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'population' => 'required|integer'
        ]);

        // Create a new city record
        Cities::create([
            'Country' => $request->input('country'),
            'City' => $request->input('city'),
            'Population' => $request->input('population')
        ]);

        return redirect()->route('cities.index')->with('success', 'City added successfully');
    }

    public function show(string $id)
    {
        $Population = cities::findOrFail($id);
 
        return view('cities.show', compact('Population'));
    }

    public function edit(string $id)
    {
        $Population = cities::findOrFail($id);
 
        return view('cities.edit', compact('Population'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'population' => 'required|integer'
        ]);

        $Population = Cities::findOrFail($id);

        $Population->update([
            'Country' => $request->input('country'),
            'City' => $request->input('city'),
            'Population' => $request->input('population')
        ]);

        return redirect()->route('cities.index')->with('success', 'City updated successfully');
    }

    public function destroy(string $id)
    {
        $Population = cities::findOrFail($id);
 
        $Population->delete();
 
        return redirect()->route('cities.index')->with('success', 'Cities deleted successfully');
    }













    //------------------DISPLAY----------------------
    public function displayCities(): View 
        {
            $cities = DB::select('SELECT * FROM cities WHERE Population > 0');
            
            if (!empty($cities)) {
                return view('cities.index', ['cities' => $cities]);
            } else {
                return 'No data found in the Cities table.';
            }
        }

    //----------------------------ADD-------------------------
    public function addCity(Request $request)
        {
            $data = $request->validate([
                'country' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'population' => 'required|integer'
            ]);

            DB::table('cities')->insert($data);

            return redirect()->route('cities')->with('success', 'City added successfully.');
        }

    //---------Delete------------------
    public function deleteCity($id)
        {

        DB::table('cities')->where('ID', $id)->delete();

        return redirect()->route('cities')->with('success', 'City deleted successfully.');
        }

}
