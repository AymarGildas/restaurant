<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PlatController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerMenuController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;  // <-- Add this import
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;

// 🚀 Landing Page with your controller to load data
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

     return redirect()->route('landing');  // <--- just redirect to the landing controller route
});

// Auth routes (login, register, forgot password, etc.)
Auth::routes();

// Customer "home" after login
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'handleContactForm'])->name('contact.submit');
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource("users",UserController::class);
        Route::resource("clients",ClientController::class);
        Route::resource("roles", RoleController::class);
        Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
        Route::get('settings/edit', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings/update', [SiteSettingController::class, 'update'])->name('settings.update');
        Route::resource('menus', MenuController::class);
        Route::resource('types', TypeController::class);
        Route::resource('plats', PlatController::class);
        Route::resource('orders', OrderController::class);
    });

    Route::prefix('customer')->name('customer.')->middleware('auth')->group(function () {
        Route::resource('orders', CustomerOrderController::class);
        Route::get('menus', [CustomerMenuController::class, 'index'])->name('menus.index');
        
        Route::resource('cart', CartController::class)->only([
            'index',    // GET /customer/cart
            'store',    // POST /customer/cart (Add to cart)
            'update',   // PUT/PATCH /customer/cart/{cart} (Update quantity)
            'destroy'   // DELETE /customer/cart/{cart} (Remove from cart)
        ]);

        // Note: These routes might be redundant if you are fully using the resource controller above.
        Route::post('cart/add/{plat}', [CartController::class, 'add'])->name('cart.add');
        Route::post('cart/remove/{plat}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('cart/update/{plat}', [CartController::class, 'update'])->name('cart.update');

        // 2. Add the new checkout routes
        Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });
});
