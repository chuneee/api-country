<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    public function index() {
        $states = State::where('status', '=', '1')->paginate(10);

        return view('states.index', compact('states'));
    }

    public function item($id) {

        $state = State::where('status', '=', '1')->where('id', '=', $id)->firstOrFail();
    
        return view('states.item', compact('state'));
    }


    public function edit($id)
    {
        $state = State::findOrFail($id);

        return view('states.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer',
        ]);
    
        $state = State::findOrFail($id);
    
        $state->name = $request->input('name');
        $state->country_id = $request->input('country_id');
        $state->save();
    
        return redirect()->route('states.index')->with('success', 'Estado actualizada exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer',
        ]);

        $state = new State();
        $state->name = $request->input('name');
        $state->country_id = $request->input('country_id');
        $state->save();

        return redirect()->route('states.index')->with('success', 'Estado agregada exitosamente.');
    }

    public function delete($id)
    {
        // Encuentra la ciudad por ID
        $state = State::find($id);
    
        // Verifica si la ciudad fue encontrada
        if (!$state) {
            return redirect()->route('states.index')->with('error', 'Estado no encontrada.');
        }
    
        // Realiza el borrado lógico
        $state->deleteLogically();
    
        return redirect()->route('states.index')->with('success', 'Estado eliminada exitosamente.');
    }

}
