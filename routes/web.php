<?php

use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StatesController;

Route::get('/', [HomeController::class, 'index'])->name('home');

//APIS COUNTRIES 
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{id}', [CountryController::class, 'item'])->name('countries.item');
Route::post('/countries', [CountryController::class, 'create']);
Route::put('/countries/{id}', [CountryController::class, 'update']);
Route::delete('/countries/{id}', [CountryController::class, 'delete']);

// APIS CITIES 
Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}', [CityController::class, 'item'])->name('cities.item');
Route::post('/cities', [CityController::class, 'create']);
Route::put('/cities/{id}', [CityController::class, 'update']);
Route::delete('/cities/{id}', [CityController::class, 'delete']);

// APIS STATES 
Route::get('/states', [StatesController::class, 'index']);
Route::get('/states/{id}', [StatesController::class, 'item'])->name('states.item');
Route::post('/states', [StatesController::class, 'create']);
Route::put('/states/{id}', [StatesController::class, 'update']);
Route::delete('/states/{id}', [StatesController::class, 'delete']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();    
});