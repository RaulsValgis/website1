<?php

namespace App\Http\Controllers\Cities;


use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;



class CitiesController extends Controller
{

    public function index()
    {
    $populationModel = Cities::with('countries')->orderBy('population')->get();

    return view('cities.index', ['model' => $populationModel]);
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'country_name' => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
        'city' => 'required|string|min:1|max:100',
        'population' => 'nullable|integer',
    ]);

    // Find or create the country based on the provided country name
    $country = Countries::firstOrCreate(['name' => $request->input('country_name')]);

    // Create a new city record and associate it with the country
    Cities::create([
        'country_id' => $country->id,
        'city' => $request->input('city'),
        'population' => $request->input('population'),
    ]);

    return redirect()->route('cities.index')->with('success', 'Data added successfully');
}

    public function show(string $id)
    {
        $populationModel = cities::findOrFail($id);
 
        return view('cities.show', [ 'model' => $populationModel ]);
    }





    public function edit(string $id)
    {
    $populationModel = Cities::with('countries')->findOrFail($id);

    return view('cities.edit', ['model' => $populationModel]);
    }






    public function update(Request $request, $id)
        {
            //dd(123);


            $rules = [
                'country'      => 'required|min:1|max:100',
                'city'         => 'required|string|min:1|max:100',
                'population'   => 'nullable|integer',
            ];
            //dd(123);
            $validator = Validator::make($request->all(), $rules);
            //dd(123);
            

            if ($validator->fails()) 
            {
                // dd($validator);
                dd($validator->errors());
                         // 422 is Unprocessable Entity status code

                // return back()->withErrors($validator)->withInput($request->all());
                
            }  

            $country = Countries::firstOrCreate(['name' => $request->input('country_name')]);
            $populationModel = Cities::findOrFail($id);
            

            $updateData = [
                'country_id' => $country->id,
                'city' => $request->input('city'),
                'population' => $request->input('population'),
            ];
            $populationModel->update($updateData);

            return redirect()->route('cities.index')->with('success', 'City updated successfully');
            
        }














    public function destroy(string $id)
    {
        $populationModel = cities::findOrFail($id);
 
        $populationModel->delete();
 
        return redirect()->route('cities.index')->with('success', 'Cities deleted successfully');
    }


}
