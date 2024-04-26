<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Contact\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/user/register', [RegisterController::class, 'register'])->name("user.register");
Route::post('/user/login', [LoginController::class, 'login'])->name("user.login");
Route::post('/contact/retrieve', [ContactController::class, 'retrieve'])->middleware("unauth.user")->name("contact.retrieve");