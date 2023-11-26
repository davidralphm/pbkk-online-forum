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

// Homepage route
Route::get('/', ['\App\Http\Controllers\QuestionController', 'index'])->name('homepage');

// Searchpage route
Route::get('/search', ['\App\Http\Controllers\QuestionController', 'search'])->name('searchpage');

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

        // Report user
        Route::get('/report/{id}', ['\App\Http\Controllers\UserController', 'report'])->middleware('auth');

        // Report user post
        Route::post('/report/{id}', ['\App\Http\Controllers\UserController', 'reportPost'])->middleware('auth');

        // Remove reply report
        Route::get('/removeReport/{id}', ['\App\Http\Controllers\UserController', 'removeReport'])->middleware('auth');

        // Reported users list
        Route::get('/reportedList/all', ['\App\Http\Controllers\UserController', 'reportedList'])->middleware('auth');

        // View all reports for a reported user
        Route::get('/reportedList/view/{id}', ['\App\Http\Controllers\UserController', 'reportedListView'])->middleware('auth');

        // Ban user page
        Route::get('/ban/{id}', ['\App\Http\Controllers\UserController', 'ban'])->middleware('auth');

        // Ban user post request
        Route::post('/ban/{id}', ['\App\Http\Controllers\UserController', 'banPost'])->middleware('auth');

        // Unban user
        Route::post('/unban/{id}', ['\App\Http\Controllers\UserController', 'unban'])->middleware('auth');
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

        // Unlock question
        Route::post('/unlock/{id}', ['\App\Http\Controllers\QuestionController', 'unlock'])->middleware('auth');

        // Report question
        Route::get('/report/{id}', ['\App\Http\Controllers\QuestionController', 'report'])->middleware('auth');

        // Report question post
        Route::post('/report/{id}', ['\App\Http\Controllers\QuestionController', 'reportPost'])->middleware('auth');

        // Remove question report
        Route::get('/removeReport/{id}', ['\App\Http\Controllers\QuestionController', 'removeReport'])->middleware('auth');

        // Reported questions list
        Route::get('/reportedList/all', ['\App\Http\Controllers\QuestionController', 'reportedList'])->middleware('auth');

        // View all reports for a reported question
        Route::get('/reportedList/view/{id}', ['\App\Http\Controllers\QuestionController', 'reportedListView'])->middleware('auth');
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

        // Undelete reply
        Route::post('/undelete/{id}', ['\App\Http\Controllers\ReplyController', 'undelete'])->middleware('auth');

        // Upvote a reply
        Route::get('/upvote/{id}', ['\App\Http\Controllers\ReplyController', 'upvote'])->middleware('auth');

        // Downvote a reply
        Route::get('/downvote/{id}', ['\App\Http\Controllers\ReplyController', 'downvote'])->middleware('auth');

        // Clear a vote
        Route::get('/unvote/{id}', ['\App\Http\Controllers\ReplyController', 'unvote'])->middleware('auth');

        // Report reply
        Route::get('/report/{id}', ['\App\Http\Controllers\ReplyController', 'report'])->middleware('auth');

        // Report reply post
        Route::post('/report/{id}', ['\App\Http\Controllers\ReplyController', 'reportPost'])->middleware('auth');

        // Remove reply report
        Route::get('/removeReport/{id}', ['\App\Http\Controllers\ReplyController', 'removeReport'])->middleware('auth');

        // Reported replies list
        Route::get('/reportedList/all', ['\App\Http\Controllers\ReplyController', 'reportedList'])->middleware('auth');

        // View all reports for a reported reply
        Route::get('/reportedList/view/{id}', ['\App\Http\Controllers\ReplyController', 'reportedListView'])->middleware('auth');
    }
);