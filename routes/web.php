<?php

use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ManufacturerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Адмінка (всі сторінки всередині адмінки)
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/manufacturers', [ManufacturerController::class, 'index']);
    Route::get('/manufacturers/edit', [ManufacturerController::class, 'edit']);
    // інші адмінські маршрути
});


