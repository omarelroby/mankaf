<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware("localization")->group(function () {
    Route::get('all-countries',[App\Http\Controllers\api\HomeController::class,'countries']);
    Route::post('user-register',[App\Http\Controllers\api\HomeController::class,'user_register']);
    Route::post('user-verify',[App\Http\Controllers\api\HomeController::class,'user_verify']);
    Route::post('user-login',[App\Http\Controllers\api\HomeController::class,'user_login']);
    Route::post('forget-password',[App\Http\Controllers\api\HomeController::class,'forget_password']);
    Route::post('reset-password',[App\Http\Controllers\api\HomeController::class,'reset_password']);

});


