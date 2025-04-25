<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Frontend\WebOrderController;
use App\Http\Controllers\Frontend\WebpageController;
use App\Http\Controllers\Frontend\WebProductController;

//frontend
Route::get('/', [WebpageController::class, 'webpage'])->name('webpage');


//customer registration routes 
Route::get('/customer', [WebpageController::class, 'form_reg'])->name('reg');
Route::post('/customer/done', [WebpageController::class, 'reg'])->name('customer.done');

Route::get('/customer/login', [WebpageController::class, 'login'])->name('login');
Route::post('/customer/success', [WebpageController::class, 'loginsuccess'])->name('customer.success');


Route::middleware('auth:customerGuard')->group(function () {
    Route::get('/customer/logout', [WebpageController::class, 'logoutsuccess'])->name('logout.success');
    Route::get('/add-to-cart/{productId}', [WebOrderController::class, 'addToCart'])->name('add.to.cart');
    Route::get('/view/add-to-cart', [WebOrderController::class, 'viewCart'])->name('view.cart');
    Route::post('/remove-from-cart/{id}', [WebOrderController::class, 'removeFromCart'])->name('frontend.remove.from.cart');
    Route::post('/update-cart/{id}', [WebOrderController::class, 'updateCart'])->name('frontend.update.cart');
    Route::get('/checkout', [WebOrderController::class, 'checkout'])->name('frontend.checkout');
    Route::post('/checkout/submit', [WebOrderController::class, 'checkoutSubmit'])->name('frontend.checkout.submit');
});

Route::get('/products', [WebProductController::class, 'product'])->name('products');


// Backend Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/do/login', [AdminController::class, 'doLogin'])->name('do.login');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/sign/out', [AdminController::class, 'signout'])->name('sign.out');
        Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');

        //customer er list view kortesi
        Route::get('/customers', [AdminController::class, 'showCustomers'])->name('customers');

        // Category Routes
        Route::get('/categories', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

        // Unit Routes
        Route::get('/units', [UnitController::class, 'unitlist'])->name('units.list');
        Route::get('units/create', [UnitController::class, 'unitcreate'])->name('units.create');
        Route::post('/units', [UnitController::class, 'unitstore'])->name('units.store');
        Route::get('/units/{unit}/edit', [UnitController::class, 'unitedit'])->name('units.edit');
        Route::put('/units/{unit}', [UnitController::class, 'unitupdate'])->name('units.update');
        Route::delete('/units/{unit}', [UnitController::class, 'unitdelete'])->name('units.delete');
        Route::get('/units/{unit}', [UnitController::class, 'unitshow'])->name('units.show');

        // Product Routes
        Route::prefix('/products')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name('products.list');
            Route::get('create', [ProductController::class, 'create'])->name('products.create');
            Route::post('store', [ProductController::class, 'store'])->name('products.store');

            Route::get('{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('{product}', [ProductController::class, 'delete'])->name('products.delete');
            Route::get('{product}', [ProductController::class, 'show'])->name('products.show');
        });
    });
});
