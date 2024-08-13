<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    public function index() {
        $states = State::where('status', '=', '1')->paginate(25);

        return view('states.index', compact('states'));
    }

    public function item($id) {

        $state = State::where('status', '=', '1')->where('id', '=', $id)->firstOrFail();
    
        return view('states.item', compact('state'));
    }
}
