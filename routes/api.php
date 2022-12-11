<?php

use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(CommonController::class)->group(function () {
    Route::name('get.')->group(function () {
        Route::get('categories', 'getCategories')->name('categories');
        Route::get('videos', 'getVideos')->name('videos');
        Route::get('promotions', 'getPromotions')->name('promotions');
        Route::get('users', 'getUsers')->name('users');
        Route::get('referrals', 'getReferrals')->name('referrals');
        Route::get('transactions', 'getTransactions')->name('transactions');
        Route::get('payouts', 'getPayouts')->name('payouts');
        Route::get('videos/logs', 'getVideoLogs')->name('videos.logs');
        Route::get('plans', 'getPlans')->name('plans');
        Route::get('users/{user}/referrals/{referralType?}', 'getUserReferrals')->name('user.referrals');
        Route::get('users/{user}/transactions', 'getUserTransactions')->name('user.transactions');
        Route::get('users/{userId}/earnings', 'getUserEarnings')->name('user.earnings');
        Route::get('faqs', 'getFaqs')->name('faqs');
    });
    
    Route::get('validate/category', 'validateUniqueCategory')->name('validate.unique.category');
    Route::post('validate/bank-account-number', 'validateAccountNumber')->name('validate.account.number');
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('plans/{plan}/payment', 'makeSubscriptionPayment')->name('plans.payment');
    Route::get('payment-callback', 'paymentCallback')->name('payment.callback');
    Route::get('transfers/{transferId}', 'fetchTransfer');
});
