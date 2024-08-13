<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function list() {
        $countries = Country::where('status', 1)->orderBy('name', 'asc')->get();

        $list = [];

        foreach ($countries as $country) {
            $object = [
                'id' => $country->id,
                'continent' => $this->getContinentName($country),
                'population' => $country->population,
                'language' => $country->language,
                'currency' => $country->currency,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function deleteList() {
        $countries = Country::where('status', 0)->orderBy('name', 'asc')->get();

        $list = [];

        foreach ($countries as $country) {
            $object = [
                'id' => $country->id,
                'continent' => $this->getContinentName($country),
                'population' => $country->population,
                'language' => $country->language,
                'currency' => $country->currency,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id) {
        $country = Country::where('status', 1)->findOrFail($id);

        $object = [
            'id' => $country->id,
            'name' => $country->name,
            'continent' => $country->continent,
            'population' => $country->population,
            'language' => $country->language,
            'currency' => $country->currency,
        ];

        return response()->json($object);
    }

    public function create(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'continent' => 'required|numeric',
            'population' => 'required',
            'language' => 'required',
            'currency' => 'required',
        ]);

        $country = Country::create([
            'name' => $data['name'],
            'continent' => $data['continent'],
            'population' => $data['population'],
            'language' => $data['language'],
            'currency' => $data['currency'],
        ]);

        if ($country) {
            $response = [
                'response' => 1,
                'message' => 'Country created successfully',
                'country' => $country
            ];

            return response()->json($response);
        } else {
            $response = [
                'response' => 0,
                'message' => 'There was an error saving data',
            ];
            return response()->json($response);
        }
    }

    public function update(Request $request) 
    {
        try {
            $data = $request->validate([
                'id' => 'required|numeric',
                'name' => 'required|string',
                'continent' => 'required|numeric',
                'population' => 'required|numeric',
                'language' => 'required|string',
                'currency' => 'required|string',
            ]);

            $country = Country::find($data['id']);

            if (!$country) {
                return response()->json([
                    'response' => 0,
                    'message' => 'Country not found',
                ], 404);
            }

            $country->name = $data['name'];
            $country->continent = $data['continent'];
            $country->population = $data['population'];
            $country->language = $data['language'];
            $country->currency = $data['currency'];

            if ($country->save()) {
                $country->refresh();

                return response()->json([
                    'response' => 1,
                    'message' => 'Country updated successfully',
                    'country' => $country
                ]);
            } else {
                return response()->json([
                    'response' => 0,
                    'message' => 'There was an error saving data',
                ], 500);
            }
        } catch (\Exception $e) {
            
            return response()->json([
                'response' => 0,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getContinentName($country) {
        switch ($country->continent) {
            case 1:
                $continent_name = 'Africa';
                break;
            case 2:
                $continent_name = 'Antartida';
                break;
            case 3:
                $continent_name = 'Norteamerica';
                break;
            case 4:
                $continent_name = 'Sudamerica';
                break;
            case 5:
                $continent_name = 'Asia';
                break;
            case 6:
                $continent_name = 'Europa';
                break;
            case 7:
                $continent_name = 'Oceania';
                break;
            default:
                $continent_name = 'Pangea';
                break;
        }
        return $continent_name;
    }

    public function delete($id)
    {
        $country = Country::findOrFail($id);
        $country->deleteLogically();

        return response()->json(['message' => 'País eliminado lógicamente.']);
    }
}
