<?php

use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StatesController;

Route::get('/', [HomeController::class, 'index'])->name('home');

//APIS COUNTRIES 
Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
Route::get('/countries/{id}', [CountryController::class, 'item'])->name('countries.item');
Route::get('/countries/edit/{id}', [CountryController::class, 'edit'])->name('countries.edit');
Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create');
Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');
Route::put('/countries/{id}', [CountryController::class, 'update'])->name('countries.update');
Route::delete('/countries/{id}', [CountryController::class, 'delete'])->name('countries.delete');

// APIS CITIES 
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{id}', [CityController::class, 'item'])->name('cities.item');
Route::get('/cities/edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');
Route::delete('/cities/{id}', [CityController::class, 'delete'])->name('cities.delete');


// APIS STATES 
Route::get('/states', [StatesController::class, 'index'])->name('states.index');
Route::get('/states/{id}', [StatesController::class, 'item'])->name('states.item');
Route::get('/states/edit/{id}', [StatesController::class, 'edit'])->name('states.edit');
Route::post('/states', [StatesController::class, 'create'])->name('states.create');
Route::post('/states', [StatesController::class, 'store'])->name('states.store');
Route::put('/states/{id}', [StatesController::class, 'update'])->name('states.update');
Route::delete('/states/{id}', [StatesController::class, 'delete'])->name('states.delete');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();    
});