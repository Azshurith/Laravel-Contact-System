<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Contact\ContactController;
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
Route::redirect('/', '/contact');

Route::group(['middleware' => 'unauth.user'], function () {
    Route::resource('/contact', ContactController::class);
    Route::get('/user/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'auth.user'], function () {
    Route::get('/user/login', [LoginController::class, 'show'])->name('login.page');
    Route::get('/user/register', [RegisterController::class, 'show'])->name('register.page');
});

Route::get('/user/register/success', [RegisterController::class, 'success'])->name('register.success');
