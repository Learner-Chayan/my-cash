<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\Api\RegisterController;
use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\Api\TransactionHistoryController;
use App\Http\Controllers\Api\SendController;
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
//Route::match(['get', 'post'], '/refresh-token',[LoginController::class,'refreshToken']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    //Route::get('/user-profile', [ProfileController::class,'index']);
    Route::prefix('home-profile')->group(function () {
        Route::post('/update-name', [ProfileController::class,'updateName']);
        Route::post('/update-image', [ProfileController::class, 'updateImage']);
     });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class,'index']);
        Route::get('/update', [ProfileController::class,'update']);
        Route::get('check-pay-pin-status', [ProfileController::class,'payPin']);
        Route::post('set-pay-pin', [ProfileController::class,'payPinStore']);
        Route::match(['put','patch'],'/change-password', [ProfileController::class,'changePassword']);
     });

    Route::prefix('send')->group(function () {
        Route::get('get-receiver', [SendController::class,'index']);
        Route::get('check-sending-balance', [SendController::class,'checkBalance']);
        Route::post('send-store', [SendController::class,'store']);
        Route::get('unlock-send-money', [SendController::class,'unlockSendMoney']);
    });

    Route::get('/wallet', [ProfileController::class, 'wallet'])->name('wallet');
    Route::match(['get', 'post'], '/refresh-token',[LoginController::class,'refreshToken']);

    // transaction
    Route::prefix(('transaction-history'))->group(function() {
        Route::get('/' , [TransactionHistoryController::class, 'list']);
        Route::get('/receives' , [TransactionHistoryController::class, 'receives']);
        Route::get('/sends' , [TransactionHistoryController::class, 'sends']);
    });

});
