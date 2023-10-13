<?php

namespace App\Http\Controllers\Cities;


use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;




class CitiesController extends Controller
{

    public function index()
    {
        $populationModel = Cities::with    ('countries')
                         ->orderBy         ('population')
                         ->get             ();
        $countries       = Countries::pluck('name');

        return view('cities.index', 
        ['model'     => $populationModel], 
        ['countries' => $countries]);
    }










    public function create()
    {
        $countries  = Countries::pluck
                    ('name');

        return view('cities.create', 
        ['countries' => $countries]);
        
    }











    public function store(Request $request)
    {
        
        $request->validate([
            'add_country_name'=> 'required|string|min:1|max:100',
            'city'            => 'required|string|min:1|max:100',
            'population'      => 'nullable|integer|max:10',
        ]);

        $country = Countries::firstOrCreate([
            'name'            => $request->input('add_country_name'
        )]);

        Cities::create([
            'country_id'      => $country
                              ->id,
            'city'            => $request
                              ->input('city'),
            'population'      => $request
                              ->input('population'),
        ]);

        return redirect()->route('cities.index')
                         ->with('success', __('Data Added Successfully') );
    }











    public function show(string $id)
    {
        $populationModel = Cities::findOrFail($id);
 
        return view('cities.show', 
        [ 'model' => $populationModel ]);
    }









    public function edit(int $id)
    { 
    $populationModel = Cities::with('countries')
                     ->findOrFail($id);

    $response = [
        'edit_country_name' => $populationModel->countries ? $populationModel
                            ->countries
                            ->name : null,
        'city'              => $populationModel
                            ->city,
        'population'        => $populationModel
                            ->population,
    ];

    return response()->json($response);
    }






    public function update(Request $request, $id)
    {
        
        $rules = [
            'edit_country_name'   => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
            'city'                => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
            'population'          => 'nullable|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput($request->all());
        }

        $country = Countries::firstOrCreate([
                 'name'     => $request->input('edit_country_name')
        ]);

        $populationModel    = Cities::findOrFail($id);

        $updateData = [
            'country_id'    => $country->id,
            'city'          => $request->input('city'),
            'population'    => $request->input('population'),
        ];

        $populationModel->update($updateData);

        return redirect()->route('cities.index')
                         ->with('success', __('City Updated Successfully') );
    }














    public function destroy(string $id)
    {
        $populationModel = Cities::findOrFail($id);
 
        $populationModel->delete();
 
        return redirect()->route('cities.index')
                         ->with('success', __('Cities Deleted Successfully') );

    }


}
