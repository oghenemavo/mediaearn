<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\User\ActivityController;
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


Route::middleware(['guest:web'])->group(function () {
    Route::get('signup/{referral_id?}', [AuthController::class, 'index']);
    Route::post('signup/create', [AuthController::class, 'create'])->name('user.create');

    Route::get('login', [AuthController::class, 'login'])->name('login.page');
    Route::post('login/create', [AuthController::class, 'authenticate'])->name('login');

    Route::get('forgot-password', [ResetPasswordController::class, 'index'])->name('password.request');
    Route::post('forgot-password', [ResetPasswordController::class, 'forgot'])->name('password.email');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'changePwd'])->name('password.update');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('password', [ProfileController::class, 'password']);
    Route::post('change-password', [ProfileController::class, 'changePwd'])->name('change.password');
    
    Route::get('video', [ActivityController::class, 'video']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/', function() {
            return redirect()->action([AdminAuthController::class, 'index']);
        });
        
        Route::controller(AdminResetPasswordController::class)->group(function () {
            Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
            Route::post('/login', [AdminAuthController::class, 'authenticate'])->name('authenticate');
            
        });
    
        Route::controller(AdminResetPasswordController::class)->group(function () {
            Route::get('forgot-password', 'index')->name('forgot.password');
            Route::post('forgot-password', 'forgot')->name('request.reset');
            Route::get('reset-password/{token}', 'showReset')->name('password.reset');
            Route::post('reset-password', 'reset')->name('reset.password');
        });
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(VideoController::class)->name('media.')->group(function () {
            Route::get('categories', 'categories')->name('categories');
            Route::post('categories', 'createCategory')->name('create.category');
            Route::put('categories/{category}', 'editCategory')->name('edit.category');

            // videos
            Route::get('videos', 'videos')->name('videos');
            Route::post('videos', 'createVideo')->name('create.video');
            Route::get('videos/{video?}', 'showVideo')->name('view.video');
            Route::put('videos/{video}', 'editVideo')->name('edit.video');
            Route::put('videos/{video}/block', 'blockVideo')->name('block.video');
            Route::put('videos/{video}/unblock', 'unblockVideo')->name('unblock.video');

        });

    });

});