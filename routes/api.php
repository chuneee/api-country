<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\StateController;

//APIS - COUNTRIES
Route::get('/countries', [CountryController::class, 'list']);
Route::get('/countries/{id}', [CountryController::class, 'item']);
Route::post('/countries', [CountryController::class, 'create']);
Route::put('/countries/{id}', [CountryController::class, 'update']);
Route::delete('/countries/{id}', [CountryController::class, 'delete']);

//APIS - CITIES
Route::get('/cities', [CityController::class, 'list']);
Route::get('/cities/{id}', [CityController::class, 'item']);
Route::post('/cities', [CityController::class, 'create']);
Route::put('/cities/{id}', [CityController::class, 'update']);
Route::delete('/cities/{id}', [CityController::class, 'delete']);

//APIS - STATES
Route::get('/states', [StateController::class, 'list']);
Route::get('/states/{id}', [StateController::class, 'item']);
Route::post('/states', [StateController::class, 'create']);
Route::put('/states/{id}', [StateController::class, 'update']);
Route::delete('/states/{id}', [StateController::class, 'delete']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();    
});