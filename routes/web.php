<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\TransactionController;
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
        Route::get('/platform-users', 'getPlatformUsers')->name('user.platform');
        Route::get('/view/{id?}', 'show')->name('user.show');
        Route::match(['get', 'post'], '/add', 'add')->name('user.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('user.edit');
        Route::post('/activate', 'activate')->name('user.activate');
        Route::post('/deactivate', 'deactivate')->name('user.deactivate');
        Route::post('/delete', 'delete')->name('user.delete');
    });

    Route::prefix('/roles')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('role');
        Route::match(['get', 'post'], '/add', 'add')->name('role.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('role.edit');
        Route::post('/delete', 'delete')->name('role.delete');
    });

    Route::prefix('/product-categories')->controller(ProductCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('product.category');
        Route::match(['get', 'post'], '/add', 'add')->name('product.category.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('product.category.edit');
        Route::post('/delete', 'delete')->name('product.category.delete');
    });

    Route::prefix('/orders')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('order');
        Route::get('/view/{id}', 'show')->name('order.show');
        Route::post('/delete', 'delete')->name('order.delete');
    });

    Route::prefix('/posts')->controller(BlogController::class)->group(function () {
        Route::get('/', 'index')->name('blog');
        Route::get('/view/{id}', 'show')->name('blog.show');
        Route::match(['get', 'post'], '/add', 'add')->name('blog.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('blog.edit');
        Route::post('/delete', 'delete')->name('blog.delete');
    });

    Route::prefix('/faqs')->controller(FAQController::class)->group(function () {
        Route::get('/', 'index')->name('faq');
        Route::get('/view/{id}', 'show')->name('faq.show');
        Route::match(['get', 'post'], '/add', 'add')->name('faq.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('faq.edit');
        Route::post('/delete', 'delete')->name('faq.delete');
    });

    Route::prefix('/testimonials')->controller(TestimonyController::class)->group(function () {
        Route::get('/', 'index')->name('testimony');
        Route::get('/view/{id}', 'show')->name('testimony.show');
        Route::post('/delete', 'delete')->name('testimony.delete');
    });

    Route::prefix('/post-categories')->controller(BlogCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('blog.category');
        Route::match(['get', 'post'], '/add', 'add')->name('blog.category.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('blog.category.edit');
        Route::post('/delete', 'delete')->name('blog.category.delete');
    });

    Route::prefix('/transactions')->controller(TransactionController::class)->group(function () {
        Route::get('/', 'index')->name('transaction');
        Route::post('/delete', 'delete')->name('transaction.delete');
    });

    Route::prefix('/packages')->controller(PackageController::class)->group(function () {
        Route::get('/', 'index')->name('package');
        Route::match(['get', 'post'], '/add', 'add')->name('package.add');
        Route::match(['get', 'post'], '/edit/{id?}', 'edit')->name('package.edit');
        Route::post('/delete', 'delete')->name('package.delete');
    });
    
});
