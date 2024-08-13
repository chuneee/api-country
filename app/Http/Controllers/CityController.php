<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index() {
        $cities = City::where('status', '=', '1')->paginate(25);

        return view('cities.index', compact('cities'));
    }

    public function item($id) {

        $city = City::where('status', '=', '1')->where('id', '=', $id)->firstOrFail();
    
        return view('cities.item', compact('city'));
    }
}
