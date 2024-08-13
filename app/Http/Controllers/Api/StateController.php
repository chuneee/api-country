<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function list() {
        $states = State::where('status', 1)->orderBy('name', 'asc')->get();

        $list = [];

        foreach ($states as $state) {
            $object = [
                'id' => $state->id,
                'name' => $state->name,
                'country' => $state->country_id,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function deleteList() {
        $states = State::where('status', 0)->orderBy('name', 'asc')->get();

        $list = [];

        foreach ($states as $state) {
            $object = [
                'id' => $state->id,
                'name' => $state->name,
                'country' => $state->country_id,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id) {
        $state = State::where('status', 1)->findOrFail($id);

        $object = [
            'id' => $state->id,
            'name' => $state->name,
            'country' => $state->country_id,
        ];

        return response()->json($object);
    }

    public function create(Request $request) {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'country_id' => 'required|numeric',
            ]);

            $state = State::create([
                'name' => $data['name'],
                'country_id' => $data['country_id'],
            ]);

            if ($state) {
                $response = [
                    'response' => 1,
                    'message' => 'State created successfully',
                    'state' => $state
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
                'country_id' => 'required|numeric',
            ]);

            $state = State::find($data['id']);

            if (!$state) {
                return response()->json([
                    'response' => 0,
                    'message' => 'State not found',
                ], 404);
            }

            $state->name = $data['name'];
            $state->country_id = $data['country_id'];

            if ($state->save()) {
                $state->refresh();

                return response()->json([
                    'response' => 1,
                    'message' => 'State updated successfully',
                    'state' => $state
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
        $state = State::findOrFail($id);
        $state->deleteLogically();

        return response()->json(['message' => 'Estado eliminado lógicamente.']);
    }
}
