<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('/products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('product');
        Route::get('/view/{id?}', 'show')->name('product.show');
        Route::match(['get', 'post'], '/add', 'add')->name('product.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('product.edit');
        Route::post('/delete', 'delete')->name('product.delete');
    });

    Route::prefix('/users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user');
        Route::match(['get', 'post'], '/add', 'add')->name('user.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('user.edit');
        Route::post('/delete', 'delete')->name('user.delete');
    });

    Route::prefix('/product-categories')->controller(ProductCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('product.category');
        Route::match(['get', 'post'], '/add', 'add')->name('product.category.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('product.category.edit');
        Route::post('/delete', 'delete')->name('product.category.delete');
    });
    
});
