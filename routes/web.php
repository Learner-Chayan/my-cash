<?php

use App\Http\Controllers\AdsApprovalController;
use App\Http\Controllers\AssetPriceController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GiftController;
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

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Auth::routes();
Route::get('/', [LoginController::class,'showLoginForm'])->name('/');
Route::group(['prefix' => 'password',],function(){
    Route::get('send-otp-email',[ForgotPasswordController::class,'email'])->name('send-otp-email');
    Route::get('send-otp-phone',[ForgotPasswordController::class,'phone'])->name('send-otp-phone');

    Route::post('send-otp',[ForgotPasswordController::class,'sendOtp'])->name('send-otp');
    Route::get('otp-check',[ForgotPasswordController::class,'checkOtp'])->name('otp-check');

    Route::post('match-otp',[ForgotPasswordController::class,'matchOtp'])->name('match-otp');
    Route::post('submit-password',[ForgotPasswordController::class,'submitPassword'])->name('submit-password');

});


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





    Route::group(['middleware' => ['Setting','check_role:super-admin|admin']], function () {

        Route::resource('asset-price',AssetPriceController::class);
        Route::resource('gift',GiftController::class);
        Route::resource('ads',AdsApprovalController::class);

    });
    Route::group(['prefix' =>'customer' ,'middleware' => ['Setting','check_role:super-admin|admin']], function () {

        Route::get('/{type}', [CustomerController::class, 'index'])->name('customer');
        Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::patch('customer-update/{customer}', [CustomerController::class, 'update'])->name('customer-update');
        Route::get('show/{id}', [CustomerController::class, 'show'])->name('show');
    });
    Route::group(['middleware' => ['Setting','check_role:super-admin']], function () {
         Route::resource('roles',RoleController::class);
         Route::resource('permissions',PermissionController::class);
         Route::resource('users',UserController::class);
     });



});
