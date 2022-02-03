<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::middleware('guest')->group(function (){
    Route::get('/password/reset', [\App\Http\Controllers\Auth\PasswordController::class, 'showLinkRequestForm'])->name('forgot_form');
    Route::post('/password/reset', [\App\Http\Controllers\Auth\PasswordController::class, 'forgot'])->name('forgot');
});

Route::middleware('auth')->group(function (){
    Route::get('/assess', [\App\Http\Controllers\AssessController::class, 'index'])->name('assess');

    Route::middleware('statusUser')->group(function (){
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
        Route::get('/user', [\App\Http\Controllers\AdminController::class, 'user'])->name('user');
        Route::post('/user/password', [\App\Http\Controllers\AdminController::class, 'passwordReset'])->name('passwordReset');
        Route::post('/user/info', [\App\Http\Controllers\AdminController::class, 'userInfo'])->name('userInfo');
        Route::post('/user/avatar', [\App\Http\Controllers\AdminController::class, 'editAvatar'])->name('editAvatar');
    });
});
