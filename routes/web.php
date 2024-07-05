<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// })->middleware('auth');

// Route::get('/cars', function () {
//     return view('cars');
// })->middleware('auth');

// Route::get('/my-cars', function () {
//     return view('/my-cars');
// })->middleware('auth');

// Route::get('/active-rentals', function () {
//     return view('active-rentals');
// })->middleware('auth');

Auth::routes();
Route::get('/', [App\Http\Controllers\CarController::class, 'allCars']);
Route::get('/home', [App\Http\Controllers\CarController::class, 'allCars']);
Route::get('/cars', [App\Http\Controllers\CarController::class, 'allCars'])->name('cars');
Route::get('/my-cars', [App\Http\Controllers\CarController::class, 'myCars'])->name('my-cars');
Route::post('/my-cars', [App\Http\Controllers\CarController::class, 'store']);
Route::delete('/my-cars/{car}', [App\Http\Controllers\CarController::class, 'destroy'])->name('my-cars.destroy');

Route::get('/active-rentals', [App\Http\Controllers\RentalController::class, 'allRentals'])->name('active-rentals');
Route::get('/rental/confirm', [App\Http\Controllers\RentalController::class, 'showConfirmationPage'])->name('rental.confirmation');
Route::post('/rental/confirm', [App\Http\Controllers\RentalController::class, 'store'])->name('rental.confirm');
Route::post('/rental/return', [App\Http\Controllers\RentalController::class, 'return'])->name('rental.return');





