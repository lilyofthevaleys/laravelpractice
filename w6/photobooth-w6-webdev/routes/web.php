<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/shop/create', [PageController::class, 'createPokemon'])->name('pokemon.create');
Route::post('/shop', [PageController::class, 'storePokemon'])->name('pokemon.store');
Route::get('/shop/{pokemon}/edit', [PageController::class, 'editPokemon'])->name('pokemon.edit');
Route::put('/shop/{pokemon}', [PageController::class, 'updatePokemon'])->name('pokemon.update');
Route::delete('/shop/{pokemon}', [PageController::class, 'destroyPokemon'])->name('pokemon.destroy');
