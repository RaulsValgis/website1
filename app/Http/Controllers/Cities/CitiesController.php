<?php

namespace App\Http\Controllers\Cities;


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
        $populationModel = Cities::orderBy('population')->get();
 
        return view('cities.index', [ 'model' => $populationModel ]);
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'country' => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
            'city' => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
            'population' => 'nullable|integer',
        ]);

        // Create a new city record
        Cities::create([
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'population' => $request->input('population'),
        ]);

        return redirect()->route('cities.index')->with('success', 'City added successfully');
    }

    public function show(string $id)
    {
        $populationModel = cities::findOrFail($id);
 
        return view('cities.show', [ 'model' => $populationModel ]);
    }

    public function edit(string $id)
    {
        $populationModel = cities::findOrFail($id);
 
        return view('cities.edit', [ 'model' => $populationModel ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'country' => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
            'city' => 'required|string|min:1|regex:/^[a-zA-Z\s]+$/|max:100',
            'population' => 'nullable|integer',
        ]);

        $populationModel = Cities::findOrFail($id);

        $populationModel->update([
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'population' => $request->input('population')
        ]);

        return redirect()->route('cities.index')->with('success', 'City updated successfully');
    }

    public function destroy(string $id)
    {
        $populationModel = cities::findOrFail($id);
 
        $populationModel->delete();
 
        return redirect()->route('cities.index')->with('success', 'Cities deleted successfully');
    }


}
