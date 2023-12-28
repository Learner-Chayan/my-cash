<?php

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
Route::get('users',[RegisterController::class,'index']);
Route::post('registration',[RegisterController::class,'register']);
Route::post('/registration',[RegisterController::class,'register']);
Route::post('/account-verification',[RegisterController::class,'accountVerify']);
Route::post('/login', [LoginController::class,'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
