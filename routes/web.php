<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Register route
Route::get('/register', ['\App\Http\Controllers\UserController', 'register'])->name('register');
Route::post('/register', ['\App\Http\Controllers\UserController', 'registerPost']);

// Login route
Route::get('/login', ['\App\Http\Controllers\UserController', 'login'])->name('login');
Route::post('/login', ['\App\Http\Controllers\UserController', 'loginPost']);

// Logout route
Route::post('/logout', ['\App\Http\Controllers\UserController', 'logout']);

// User routes
Route::prefix('/user')->name('user.')->group(
    function() {
        Route::get('dashboard', ['\App\Http\Controllers\UserController', 'dashboard'])->name('dashboard')->middleware('auth');
    }
);