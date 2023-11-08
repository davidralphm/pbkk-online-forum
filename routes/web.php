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

// Account controller
Route::controller('\App\Http\Controllers\AccountController')->prefix('account')->name('account.')->group(
    function() {
        // Get routes
        Route::get('/', 'index')->name('index');
        Route::get('/login', 'login')->name('login');
        Route::get('/register', 'register')->name('register');
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/edit', 'edit')->name('edit');
        Route::get('/delete', 'delete')->name('delete');

        // Post routes
        Route::post('/login', 'loginPost');
        Route::post('/register', 'registerPost');
        Route::post('/logout', 'logout');
        Route::post('/edit', 'editPost');
        Route::post('/delete', 'deletePost');
    }
);

// Question controller
Route::controller('\App\Http\Controllers\QuestionController')->prefix('question')->name('question.')->group(
    function() {
        Route::get('/', 'index');
        Route::get('/index', 'index');

        Route::get('/page/{page}', 'page');

        Route::get('/{id}/replies/{page}', 'replies');
    }
);

// Post controller
Route::controller('\App\Http\Controllers\PostController')->prefix('post')->name('post.')->group(
    function() {
        Route::get('/{post_id}/replies', 'replies');
        Route::get('/{post_id}/replies/{page}', 'repliesPaged');
    }
);

Route::controller('\App\Http\Controllers\AboutController')->prefix('about')->name('about.')->group(
    function() {
        Route::get('/', 'index');
        Route::get('/parento', 'parento')->name('parento');
    }
);
