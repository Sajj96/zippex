<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/healthcheck', function(){
    return response()->json(["Aloha" => "Alive and well"], 200);
});

//URL begins with api/auth/<endpoint>
//These end points are not authenticated
Route::group(['prefix' => 'auth' ], function () {
    Route::post('/register', [\App\Http\Controllers\API\AuthController::class,'register'])->name('register');
    Route::post('/login', [\App\Http\Controllers\API\AuthController::class,'login'])->name('login');
    Route::post('forgot-password', [App\Http\Controllers\API\PasswordResetController::class, 'resetPassword'])->name('reset.password.post');
    Route::post('confirm-password', [App\Http\Controllers\API\PasswordResetController::class, 'confirmPassword'])->name('reset.password.post');
});

Route::middleware('auth:api')->group(function ()
{
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class,'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\API\AuthController::class,'refresh'])->name('refresh.token');
    Route::post('me', [\App\Http\Controllers\API\AuthController::class,'me'])->name('me');
    Route::post('change-password', [\App\Http\Controllers\API\PasswordResetController::class,'changePassword'])->name('change.password');

    Route::group(['prefix' => 'users' ], function () {
        Route::get('/', [\App\Http\Controllers\API\UserController::class,'index'])->name('user');
        Route::post('/details', [\App\Http\Controllers\API\UserController::class,'getUser'])->name('user.phone');
    });
});
