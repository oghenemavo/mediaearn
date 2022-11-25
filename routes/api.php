<?php

use App\Http\Controllers\Api\CommonController;
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
    });
    
    Route::get('validate/category', 'validateUniqueCategory')->name('validate.unique.category');
});
