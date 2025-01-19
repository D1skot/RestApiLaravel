<?php

use App\Http\Controllers\PetController;

Route::get('/', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');

Route::get('/pets/edit/{id}', [PetController::class, 'edit'])->name('pets.edit');
Route::put('/pets/update/{id}', [PetController::class, 'update'])->name('pets.update');

Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
