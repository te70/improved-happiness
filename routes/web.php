<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DivisionsController;


Route::get('/', function () {
    return view('welcome');
}); 

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/home/create', [HomeController::class, 'create'])->name('home.create');
Route::post('/home/store', [HomeController::class, 'store'])->name('home.store');
Route::get('/home/edit/{id}', [HomeController::class, 'edit'])->name('home.edit');
Route::post('/home/update/{id}', [HomeController::class, 'update'])->name('home.update');
Route::delete('/home/delete', [HomeController::class, 'destroy'])->name('home.delete');
Route::get('/home/details/{id}', [HomeController::class, 'details'])->name('home.details');

Route::get('/divisions', [DivisionsController::class, 'index'])->name('divisions');
Route::get('/divisions/create', [DivisionsController::class, 'create'])->name('divisions.create');
Route::post('/divisions/store', [DivisionsController::class, 'store'])->name('divisions.store');
Route::get('/division/details/{division}', [DivisionsController::class, 'show'])->name('divisions.details');

