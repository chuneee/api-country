<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function list() {
        $cities = City::where('status', 1)->orderBy('name', 'asc')->get();

        $list = [];

        foreach ($cities as $city) {
            $object = [
                'id' => $city->id,
                'name' => $city->name,
                'state' => $city->state,
                'isCapital' => $city->isCapital,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function deletelist() {
        $cities = City::where('status', 0)->orderBy('name', 'asc')->get();

        $list = [];

        foreach ($cities as $city) {
            $object = [
                'id' => $city->id,
                'name' => $city->name,
                'state' => $city->state,
                'isCapital' => $city->isCapital,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id) {
        $city = City::where('status', 1)->findOrFail($id);

        $object = [
            'id' => $city->id,
            'name' => $city->name,
            'state' => $city->state,
            'isCapital' => $city->isCapital,
        ];

        return response()->json($object);
    }

    public function create(Request $request) {
        try {
            $data = $request->validate([
                'name' => 'required',
                'state_id' => 'required|numeric',
                'isCapital' => 'nullable|numeric'
            ]);

            $isCapital = isset($data['isCapital']) ? $data['isCapital'] : 0;

            $city = City::create([
                'name' => $data['name'],
                'state_id' => $data['state_id'],
                'isCapital' => $isCapital
            ]);

            if ($city) {
                $response = [
                    'response' => 1,
                    'message' => 'City created successfully',
                    'city' => $city
                ];

                return response()->json($response);
            } else {
                $response = [
                    'response' => 0,
                    'message' => 'There was an error saving data'
                ];

                return response()->json($response);
            }
        } catch (\Exception $e) {
            return response()->json([
                'response' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->validate([
                'id' => 'required|numeric',
                'name' => 'required|string',
                'state_id' => 'required|numeric',
                'isCapital' => 'nullable|numeric'
            ]);

            $city = City::find($data['id']);

            if (!$city) {
                return response()->json([
                    'response' => 0,
                    'message' => 'City not found',
                ], 404);
            }

            $city->name = $data['name'];
            $city->state_id = $data['state_id'];
            $city->isCapital = isset($data['isCapital']) ? $data['isCapital'] : $city->isCapital;


            if ($city->save()) {

                $city->refresh();

                return response()->json([
                    'response' => 1,
                    'message' => 'City updated successfully',
                    'city' => $city
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

    public function delete($id)
    {
        $city = City::findOrFail($id);
        $city->deleteLogically();

        return response()->json(['message' => 'Ciudad eliminada lógicamente.']);
    }
}
