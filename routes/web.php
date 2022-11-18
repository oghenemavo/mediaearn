<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ResetPasswordController;
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
})->name('homepage');

// Route::name('')->group(function () {

    Route::middleware(['guest'])->group(function () {
        Route::get('signup/{referral_id?}', [AuthController::class, 'index']);
        Route::post('signup/create', [AuthController::class, 'create'])->name('create');

        Route::get('login', [AuthController::class, 'login'])->name('login.page');
        Route::post('login/create', [AuthController::class, 'authenticate'])->name('login');

        Route::get('forgot-password', [ResetPasswordController::class, 'index'])->name('password.request');
        Route::post('forgot-password', [ResetPasswordController::class, 'forgot'])->name('password.email');

        Route::get('reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('password.reset');
        Route::post('reset-password', [ResetPasswordController::class, 'changePwd'])->name('password.update');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('password', [ProfileController::class, 'password']);
        Route::post('change-password', [ProfileController::class, 'changePwd'])->name('change.password');
    });
    
// });
