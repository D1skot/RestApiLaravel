<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
