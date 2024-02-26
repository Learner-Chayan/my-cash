<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\Api\RegisterController;
use App\Http\Controllers\Auth\Api\LoginController;
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
Route::post('/registration',[RegisterController::class,'register']);
Route::post('/account-verification',[RegisterController::class,'accountVerify']);
Route::post('/login', [LoginController::class,'login']);
Route::match(['get', 'post'], '/refresh-token',[LoginController::class,'refreshToken']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    //Route::get('/user-profile', [ProfileController::class,'index']);
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class,'index']);
        Route::get('/update', [ProfileController::class,'update']);
        Route::match(['put','patch'],'/change-password', [ProfileController::class,'changePassword']);
     });

     Route::get('/wallet', [ProfileController::class, 'wallet'])->name('wallet');
});
