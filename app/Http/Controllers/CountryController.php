<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index() {
        $countries = Country::where('status', '=', '1')->paginate(11);

        return view('countries.index', compact('countries'));
    }

    public function item($id) {

        $country = Country::where('status', '=', '1')->where('id', '=', $id)->firstOrFail();
    
        return view('countries.item', compact('country'));
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);

        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'continent' => 'required|string|max:255',
            'population' => 'required|integer',
            'language' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
        ]);
    
        $country = Country::findOrFail($id);
    
        $country->name = $request->input('name');
        $country->continent = $request->input('continent');
        $country->population = $request->input('population');
        $country->language = $request->input('language');
        $country->currency = $request->input('currency');
        $country->save();
    
        return redirect()->route('countries.index')->with('success', 'País actualizado exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'continent' => 'required|string|max:255',
            'population' => 'required|integer',
            'language' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
        ]);

        $country = new Country();
        $country->name = $request->input('name');
        $country->continent = $request->input('continent');
        $country->population = $request->input('population');
        $country->language = $request->input('language');
        $country->currency = $request->input('currency');
        $country->save();

        return redirect()->route('countries.index')->with('success', 'País agregado exitosamente.');
    }

    public function delete($id)
    {
        // Encuentra la ciudad por ID
        $country = Country::find($id);
    
        // Verifica si la ciudad fue encontrada
        if (!$country) {
            return redirect()->route('countries.index')->with('error', 'Pais no encontrada.');
        }
    
        // Realiza el borrado lógico
        $country->deleteLogically();
    
        return redirect()->route('countries.index')->with('success', 'Pais eliminada exitosamente.');
    }
}
