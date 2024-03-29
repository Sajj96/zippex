<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogCategoryController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\PasswordResetController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\UserAddressController;
use App\Http\Controllers\API\UserController;
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
Route::prefix('/auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('auth.register');
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout')->middleware('auth:api');
    Route::post('/refresh', 'refresh')->name('refresh.token')->middleware('auth:api');
    Route::post('/me', 'me')->name('me')->middleware('auth:api');
});

Route::prefix('/passwords')->controller(PasswordResetController::class)->group(function () {
    Route::post('/forgot-password', 'resetPassword')->name('password.forgot');
    Route::post('/change-password', 'changePassword')->name('password.change')->middleware('auth:api');
});

Route::middleware('auth:api')->group(function ()
{
    Route::prefix('/products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('product.all');
        Route::get('/view/{id}', 'show')->name('product.view');
        Route::get('/search/{slug?}', 'search')->name('product.search');
    });

    Route::get('/users/downlines', [App\Http\Controllers\API\UserController::class, 'getDownlines'])->name('user.downlines');

    Route::prefix('/addresses')->controller(UserAddressController::class)->group(function () {
        Route::get('/', 'index')->name('address.all');
        Route::post('/add', 'add')->name('address.add');
    });

    Route::prefix('/product-categories')->controller(ProductCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('category.all');
        Route::get('/view/{id}', 'getProducts')->name('category.product');
    });

    Route::prefix('/carts')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('cart.all');
        Route::post('/add', 'add')->name('cart.add');
        Route::post('/edit', 'edit')->name('cart.edit');
        Route::post('/delete', 'delete')->name('cart.delete');
    });

    Route::prefix('/orders')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('order.all');
        Route::get('/view/{id}', 'show')->name('order.view');
        Route::post('/add', 'add')->name('order.add');
    });

    Route::prefix('/posts')->controller(BlogController::class)->group(function () {
        Route::get('/', 'getAll')->name('post.all');
        Route::get('/view/{id}', 'getOne')->name('post.view');
    });

    Route::prefix('/post-categories')->controller(BlogCategoryController::class)->group(function () {
        Route::get('/', 'getAll')->name('post.category.all');
        Route::get('/view/{id}', 'getOne')->name('post.category.view');
    });

    Route::prefix('/packages')->controller(PackageController::class)->group(function () {
        Route::get('/', 'getAll')->name('package.all');
    });
});
