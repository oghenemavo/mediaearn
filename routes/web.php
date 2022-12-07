<?php

use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('category/{category:slug}', [HomeController::class, 'category'])->name('category');
Route::get('video/{video:slug}', [ActivityController::class, 'video'])->name('get.video');
Route::get('pricing', [HomeController::class, 'pricing'])->name('pricing');

Route::middleware(['guest:web'])->group(function () {
    Route::get('signup/{referral_id?}', [AuthController::class, 'index'])->name('signup.page');
    Route::post('signup', [AuthController::class, 'create'])->name('user.create');

    Route::get('login', [AuthController::class, 'login'])->name('login.page');
    Route::post('login', [AuthController::class, 'authenticate'])->name('login');

    Route::get('forgot-password', [ResetPasswordController::class, 'index'])->name('password.request');
    Route::post('forgot-password', [ResetPasswordController::class, 'forgot'])->name('password.email');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'changePwd'])->name('password.update');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('referrals', [ActivityController::class, 'referrals'])->name('user.referrals');
    Route::get('rewards', [ActivityController::class, 'rewards'])->name('user.rewards');
    Route::get('transactions', [ActivityController::class, 'transactions'])->name('user.transactions');
    Route::get('earnings', [ActivityController::class, 'earnings'])->name('user.earnings');

    Route::post('change-email', [ProfileController::class, 'email'])->name('change.email');
    Route::post('change-password', [ProfileController::class, 'password'])->name('change.password');
    Route::post('change-account-info', [ProfileController::class, 'accountInfo'])->name('change.account.info');
    
    Route::post('videos/{video}/reward', [ActivityController::class, 'getReward'])->name('get.user.reward');
    Route::post('request-payout', [ActivityController::class, 'requestPayout'])->name('request.payout');
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
        Route::get('manage/users', [DashboardController::class, 'showUsers'])->name('users');
        Route::put('users/{user}/suspend', [DashboardController::class, 'suspendUser'])->name('suspend.user');
        Route::put('users/{user}/activate', [DashboardController::class, 'activateUser'])->name('activate.user');
        Route::get('settings', [AppController::class, 'index'])->name('app.settings');
        Route::put('settings/{settings}', [AppController::class, 'edit'])->name('edit.app.settings');
        Route::put('update/password', [AppController::class, 'updatePassword'])->name('update.password');
        Route::put('update/email', [AppController::class, 'emailPassword'])->name('update.email');

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
        
        // advertisements
        Route::controller(PromotionController::class)->prefix('promotions')->name('media.')->group(function () {
            Route::get('/', 'index')->name('promotions');
            Route::post('/', 'store')->name('create.promotions');
            Route::get('/{promotion}', 'show')->name('show.promotion');
            Route::put('/{promotion}', 'edit')->name('edit.promotion');
            Route::put('/{promotion}/block', 'block')->name('block.promotion');
            Route::put('/{promotion}/unblock', 'unblock')->name('unblock.promotion');
        });

        Route::controller(ReportController::class)->prefix('report')->name('report.')->group(function () {
            Route::get('referrals', 'referrals')->name('referrals');
        });

        Route::controller(PlanController::class)->prefix('plans')->group(function () {
            Route::get('/', 'index')->name('plans');
            Route::post('/', 'store')->name('create.plans');
            Route::get('/{plan}', 'show')->name('show.plans');
            Route::put('/{plan}', 'edit')->name('edit.plans');
            Route::put('/{plan}/deactivate', 'deactivate')->name('deactivate.plans');
            Route::put('/{plan}/activate', 'activate')->name('activate.plans');
        });
    });

});