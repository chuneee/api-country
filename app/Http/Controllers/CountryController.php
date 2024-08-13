<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index() {
        $countries = Country::where('status', '=', '1')->paginate(25);

        return view('countries.index', compact('countries'));
    }

    public function item($id) {

        $country = Country::where('status', '=', '1')->where('id', '=', $id)->firstOrFail();
    
        return view('countries.item', compact('country'));
    }
}
