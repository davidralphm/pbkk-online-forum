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
Route::get('/logout', ['\App\Http\Controllers\UserController', 'logout']);

// User routes
Route::prefix('/user')->name('user.')->group(
    function() {
        // Dashboard
        Route::get('dashboard', ['\App\Http\Controllers\UserController', 'dashboard'])->name('dashboard')->middleware('auth');
        
        // View profile
        Route::get('/profile/{id}', ['\App\Http\Controllers\UserController', 'profile'])->name('profile');

        // Edit account
        Route::post('/editAccount', ['\App\Http\Controllers\UserController', 'edit'])->middleware('auth');

        // Change password
        Route::post('/changePassword', ['\App\Http\Controllers\UserController', 'changePassword'])->middleware('auth');

        // Delete account
        Route::post('/deleteAccount', ['\App\Http\Controllers\UserController', 'delete'])->middleware('auth');

        // Delete profile image
        Route::get('/deleteImage', ['\App\Http\Controllers\UserController', 'deleteImage'])->middleware('auth');
    }
);

// Question routes
Route::prefix('/question')->name('question.')->group(
    function() {
        // Create question page
        Route::get('/create', ['\App\Http\Controllers\QuestionController', 'create'])->middleware('auth');

        // Create question post
        Route::post('/create', ['\App\Http\Controllers\QuestionController', 'createPost'])->middleware('auth');

        // Show question page
        Route::get('/view/{id}', ['\App\Http\Controllers\QuestionController', 'view']);

        // Reply to question
        Route::post('/reply/{id}', ['\App\Http\Controllers\QuestionController', 'reply'])->middleware('auth');

        // Edit question
        Route::get('/edit/{id}', ['\App\Http\Controllers\QuestionController', 'edit'])->middleware('auth');

        // Edit question post
        Route::post('/edit/{id}', ['\App\Http\Controllers\QuestionController', 'editPost'])->middleware('auth');

        // Lock question
        Route::post('/lock/{id}', ['\App\Http\Controllers\QuestionController', 'lock'])->middleware('auth');
    }
);

// Reply routes
Route::prefix('/reply')->name('reply.')->group(
    function() {
        // Edit reply page
        Route::get('/edit/{id}', ['\App\Http\Controllers\ReplyController', 'edit'])->middleware('auth');

        // Edit reply post
        Route::post('/edit/{id}', ['\App\Http\Controllers\ReplyController', 'editPost'])->middleware('auth');

        // Delete reply
        Route::post('/delete/{id}', ['\App\Http\Controllers\ReplyController', 'delete'])->middleware('auth');
    }
);