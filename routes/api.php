<?php

use App\Http\Controllers\Auth\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Api\RegisterController;

//Route::get('users',[\App\Http\Controllers\Auth\Api\RegisterController::class,'index']);
Route::post('/registration',[RegisterController::class,'register']);
Route::post('/login', [LoginController::class,'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
