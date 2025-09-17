<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SerpController;

Route::get('/', [SerpController::class, 'index'])->name('home');
Route::post('/search', [SerpController::class, 'search'])->name('search');
Route::get('/test-api', [\App\Http\Controllers\SerpController::class, 'testApi']);


/*Route::get('/', function () {
    return view('welcome');
});*/
