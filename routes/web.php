<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BasicController;

Route::get('/clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return "All Clear";
//    return redirect()->route('dashboard');
});

Auth::routes();
Route::get('/', [LoginController::class,'showLoginForm'])->name('/');
Route::get('dashboard',[HomeController::class,'dashboard'])->name('dashboard')->middleware('auth');

Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {

    Route::get('edit-profile', [HomeController::class, 'editProfile'])->name('edit-profile');
    Route::post('edit-profile', [HomeController::class, 'updateProfile'])->name('update-profile');

    Route::get('password', [HomeController::class, 'changePassword'])->name('password');
    Route::post('change-password', [HomeController::class, 'updatePassword'])->name('change-password');

    Route::get('get-basic', [BasicController::class, 'index'])->name('get-basic');
    Route::post('get-basic-update', [BasicController::class, 'update'])->name('get-basic-update');
    Route::get('get-copy-right', [BasicController::class, 'indexCopy'])->name('get-copy-right');
    Route::post('get-copy-right-update', [BasicController::class, 'updateCopy'])->name('get-copy-right-update');
//Route::get('get-about', [BasicController::class, 'about'])->name('get-about');
//Route::post('get-about-update', [BasicController::class, 'aboutUpdate'])->name('get-about-update');
//Route::get('get-privacy', [BasicController::class, 'privacy'])->name('get-privacy');
//Route::post('get-privacy-update', [BasicController::class, 'privacyUpdate'])->name('get-privacy-update');
//Route::get('get-terms', [BasicController::class, 'terms'])->name('get-terms');
//Route::post('get-terms-update', [BasicController::class, 'termsUpdate'])->name('get-terms-update');


     Route::resource('roles',RoleController::class);
     Route::resource('permissions',PermissionController::class);
     Route::resource('users',UserController::class);



});
