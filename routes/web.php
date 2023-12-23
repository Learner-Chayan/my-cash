<?php

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
//Route::get('dashboard',['as' => 'dashboard' , 'uses' => 'HomeController@dashboard'])->middleware('auth');
Route::get('dashboard',[HomeController::class,'dashboard'])->name('dashboard')->middleware('auth');

Route::get('auth/google', 'LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'LoginController@handleGoogleCallback');
Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {

    //Route::get('edit-profile', ['as' => 'edit-profile', 'uses' => 'HomeController@editProfile']);
    Route::get('edit-profile', [HomeController::class, 'editProfile'])->name('edit-profile');

    // Route::post('edit-profile', ['as' => 'update-profile', 'uses' => 'HomeController@updateProfile']);
    // Route::get('password',['as' => 'password','uses'=> 'HomeController@changePassword']);
    // Route::post('change-password',['as' => 'change-password','uses'=> 'HomeController@updatePassword']);
    // Route::get('get-about', ['as' => 'get-about', 'uses' => 'BasicController@about']);
    // Route::post('get-about-update', ['as' => 'get-about-update', 'uses' => 'BasicController@aboutUpdate']);
    // Route::get('get-privacy', ['as' => 'get-privacy', 'uses' => 'BasicController@privacy']);
    // Route::post('get-privacy-update', ['as' => 'get-privacy-update', 'uses' => 'BasicController@privacyUpdate']);
    // Route::get('get-terms', ['as' => 'get-terms', 'uses' => 'BasicController@terms']);
    // Route::post('get-terms-update', ['as' => 'get-terms-update', 'uses' => 'BasicController@termsUpdate']);
    // Route::get('get-basic', ['as' => 'get-basic', 'uses' => 'BasicController@index']);
    // Route::get('get-basic', ['as' => 'get-basic', 'uses' => 'BasicController@index']);
    // Route::post('get-basic-update', ['as' => 'get-basic-update', 'uses' => 'BasicController@update']);
    // Route::get('get-copy-right', ['as' => 'get-copy-right', 'uses' => 'BasicController@indexCopy']);
    // Route::post('get-copy-right-update', ['as' => 'get-copy-right-update', 'uses' => 'BasicController@updateCopy']);


Route::post('edit-profile', [HomeController::class, 'updateProfile'])->name('update-profile');
Route::get('password', [HomeController::class, 'changePassword'])->name('password');
Route::post('change-password', [HomeController::class, 'updatePassword'])->name('change-password');
Route::get('get-about', [BasicController::class, 'about'])->name('get-about');
Route::post('get-about-update', [BasicController::class, 'aboutUpdate'])->name('get-about-update');
Route::get('get-privacy', [BasicController::class, 'privacy'])->name('get-privacy');
Route::post('get-privacy-update', [BasicController::class, 'privacyUpdate'])->name('get-privacy-update');
Route::get('get-terms', [BasicController::class, 'terms'])->name('get-terms');
Route::post('get-terms-update', [BasicController::class, 'termsUpdate'])->name('get-terms-update');
Route::get('get-basic', [BasicController::class, 'index'])->name('get-basic');
Route::post('get-basic-update', [BasicController::class, 'update'])->name('get-basic-update');
Route::get('get-copy-right', [BasicController::class, 'indexCopy'])->name('get-copy-right');
Route::post('get-copy-right-update', [BasicController::class, 'updateCopy'])->name('get-copy-right-update');


    // Route::resource('roles','RoleController');
    // Route::resource('permissions','PermissionController');
    // Route::resource('users','UserController');
    // Route::resource('sliders','Controllers\SliderController');
    // Route::resource('socials','Controllers\SocialController');
    // Route::resource('faqs','Controllers\FaqController');

    // Route::get('advertisement', ['as' => 'advertisement', 'uses' => 'controllers\FaqController@indexAdvertisement']);
    // Route::get('advertisement-create', ['as' => 'advertisement-create', 'uses' => 'controllers\FaqController@createAdvertisement']);
    // Route::post('advertisement-store', ['as' => 'advertisement-store', 'uses' => 'controllers\FaqController@storeAdvertisement']);
    // Route::get('advertisement-edit/{id}', ['as' => 'advertisement-edit', 'uses' => 'controllers\FaqController@editAdvertisement']);
    // Route::post('advertisement-update', ['as' => 'advertisement-update', 'uses' => 'controllers\FaqController@updateAdvertisement']);
    // Route::delete('advertisement-delete', ['as' => 'advertisement-delete', 'uses' => 'controllers\FaqController@deleteAdvertisement']);
});
