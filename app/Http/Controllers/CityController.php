<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;



class CityController extends Controller
{
    public function index() {
        $cities = City::where('status', '=', '1')->paginate(110);

        return view('cities.index', compact('cities'));
    }

    public function item($id) {

        $city = City::where('status', '=', '1')->where('id', '=', $id)->firstOrFail();
    
        return view('cities.item', compact('city'));
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);

        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|integer',
        ]);
    
        $city = City::findOrFail($id);
    
        $city->name = $request->input('name');
        $city->state_id = $request->input('state_id');
        $city->save();
    
        return redirect()->route('cities.index')->with('success', 'Ciudad actualizada exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|integer',
        ]);

        $city = new City();
        $city->name = $request->input('name');
        $city->state_id = $request->input('state_id');
        $city->save();

        return redirect()->route('cities.index')->with('success', 'Ciudad agregada exitosamente.');
    }

    public function delete($id)
    {
        // Encuentra la ciudad por ID
        $city = City::find($id);
    
        // Verifica si la ciudad fue encontrada
        if (!$city) {
            return redirect()->route('cities.index')->with('error', 'Ciudad no encontrada.');
        }
    
        // Realiza el borrado lógico
        $city->deleteLogically();
    
        return redirect()->route('cities.index')->with('success', 'Ciudad eliminada exitosamente.');
    }

}
