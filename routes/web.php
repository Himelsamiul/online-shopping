<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\NavbarController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Frontend\WebOrderController;
use App\Http\Controllers\Frontend\WebpageController;
use App\Http\Controllers\Frontend\WebProductController;
use App\Http\Controllers\SslCommerzPaymentController;

// Frontend
Route::get('/', [WebpageController::class, 'webpage'])->name('webpage');
Route::get('/about-us', [NavbarController::class, 'aboutus'])->name('aboutus');
Route::get('/contact-us', [NavbarController::class, 'contactus'])->name('contactus');
Route::post('/contact-us', [NavbarController::class, 'contactusSubmit'])->name('contactus.submit');

Route::get('/search', [ProductController::class, 'search'])->name('search.products');

// Customer Registration Routes
Route::get('/customer', [WebpageController::class, 'form_reg'])->name('reg');
Route::post('/customer/done', [WebpageController::class, 'reg'])->name('customer.done');

Route::delete('/customers/{id}', [WebpageController::class, 'destroy'])->name('customers.destroy');


Route::get('/customer/login', [WebpageController::class, 'login'])->name('login');
Route::post('/customer/success', [WebpageController::class, 'loginsuccess'])->name('customer.success');

Route::middleware('auth:customerGuard')->group(function () {
    Route::get('/customer/logout', [WebpageController::class, 'logoutsuccess'])->name('logout.success');
    Route::get('/profile', [WebpageController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [WebpageController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [WebpageController::class, 'updateProfile'])->name('profile.update');
    Route::get('/add-to-cart/{productId}', [WebOrderController::class, 'addToCart'])->name('add.to.cart');
    Route::get('/view/add-to-cart', [WebOrderController::class, 'viewCart'])->name('view.cart');
    Route::post('/remove-from-cart/{id}', [WebOrderController::class, 'removeFromCart'])->name('frontend.remove.from.cart');
    Route::post('/update-cart/{id}', [WebOrderController::class, 'updateCart'])->name('frontend.update.cart');
    Route::get('/checkout', [WebOrderController::class, 'checkout'])->name('frontend.checkout');
    Route::post('/checkout/submit', [WebOrderController::class, 'checkoutSubmit'])->name('frontend.checkout.submit');
    Route::get('details/{id}', [OrderController::class, 'viewOrderDetails'])->name('customer.order.details');

    //navbar routes

    Route::post('/product/{id}/review', [WebProductController::class, 'storeReview'])->name('submit.review');

    // SSLCOMMERZ Start
    Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
    Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

    Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
    Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

    Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
    //SSLCOMMERZ END
});

Route::get('/products/category/{categoryId?}', [WebProductController::class, 'product'])->name('products');
Route::get('/product/{id}', [WebProductController::class, 'singleProduct'])->name('product.single');

// Backend Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/do/login', [AdminController::class, 'doLogin'])->name('do.login');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/sign/out', [AdminController::class, 'signout'])->name('sign.out');
        Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');

        // Customer List View
        Route::get('/customers', [AdminController::class, 'showCustomers'])->name('customers');

        // Category Routes
        Route::get('/categories/list', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

        //contact us view
        Route::get('/contact-us-view', [NavbarController::class, 'contactusview'])->name('contactusview');
        Route::delete('/contact-delete/{id}', [NavbarController::class, 'destroy'])->name('contact.destroy');

        // Unit Routes
        Route::get('/units', [UnitController::class, 'unitlist'])->name('units.list');
        Route::get('/units/create', [UnitController::class, 'unitcreate'])->name('units.create');
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

        // Order Routes
        Route::prefix('/orders')->group(function () {
            Route::get('/list', [OrderController::class, 'list'])->name('order.list');
            // New route for order details
        });

        // Order details Routes
        Route::prefix('/order')->group(function () {
            Route::get('details/{id}', [OrderController::class, 'details'])->name('order.details');
        });

        Route::prefix('/report')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('report');
        });

        Route::prefix('/review')->group(function () {
            Route::get('/', [ReviewController::class, 'list'])->name('review');
        });
    });

});
