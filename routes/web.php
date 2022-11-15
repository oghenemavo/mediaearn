<?php

use App\Http\Controllers\User\AuthController;
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

Route::name('user.')->group(function () {

    Route::middleware(['guest'])->group(function () {
        Route::get('signup/{referral_id?}', [AuthController::class, 'index']);
        Route::post('signup/create', [AuthController::class, 'create'])->name('create');

        Route::get('login', [AuthController::class, 'login']);
        Route::post('login/create', [AuthController::class, 'authenticate'])->name('login');
    });
    
});
