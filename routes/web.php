<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TailorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SesiController::class, 'showLogin'])->name('login');
    Route::post('/login', [SesiController::class, 'login'])->name('login.action');
    Route::get('/register', [SesiController::class, 'showRegister'])->name('register');
    Route::post('/register', [SesiController::class, 'register'])->name('register.action');
});

Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    // Rute untuk pengelolaan layanan
    Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');
    Route::get('/admin/services/create', [AdminController::class, 'createService'])->name('admin.createService');
    Route::post('/admin/services', [AdminController::class, 'storeService'])->name('admin.storeService');
    Route::get('/admin/services/{service}/edit', [AdminController::class, 'editService'])->name('admin.editService');
    Route::put('/admin/services/{service}', [AdminController::class, 'updateService'])->name('admin.updateService');
    Route::delete('/admin/services/{service}', [AdminController::class, 'destroyService'])->name('admin.destroyService');

    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/admin/order/{order}/verify', [AdminController::class, 'verifyPayment'])->name('admin.verifyPayment');
});

Route::middleware(['auth', 'role:penjahit'])->group(function () {
    Route::get('/penjahit', [TailorController::class, 'index'])->name('tailor.index');
    Route::get('/penjahit/profile', [TailorController::class, 'showProfile'])->name('tailor.showProfile');
    Route::post('/penjahit/profile', [TailorController::class, 'profile'])->name('tailor.profile');
    Route::post('/penjahit/order/{order}/status', [TailorController::class, 'updateStatus'])->name('tailor.updateStatus');

    Route::view('/penjahit/contact', 'penjahit.contact')->name('penjahit.contact');
    Route::view('/penjahit/about', 'penjahit.about')->name('penjahit.about');
   
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::view('/pelanggan', 'pelanggan.dashboard')->name('pelanggan.dashboard');
    Route::view('/contact', 'layouts.contact')->name('contact');
    Route::view('/about', 'layouts.about')->name('about');

});

Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('pelanggan.profile');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customer/order', [CustomerController::class, 'createOrder'])->name('customer.createOrder');
    Route::get('/customer/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::post('/customer/order/{order}/payment', [CustomerController::class, 'uploadPayment'])->name('customer.uploadPayment');
    Route::get('/services/{service}/tailors', [CustomerController::class, 'getTailorsByService'])->name('customer.getTailorsByService');
    Route::delete('/customer/order/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('customer.cancelOrder');
    Route::get('/payment-info', [CustomerController::class, 'paymentInfo'])->name('payment.info');

    // Route::get('/penjahit', [TailorController::class, 'index'])->name('tailor.index');
    // Route::get('/tailor/profile', [TailorController::class, 'showProfile'])->name('tailor.showProfile');
    // Route::post('/tailor/profile', [TailorController::class, 'profile'])->name('tailor.profile');
    // Route::post('/tailor/order/{order}/status', [TailorController::class, 'updateStatus'])->name('tailor.updateStatus');
});

Route::get('/order', function () {
    return view('pelanggan.order');
})->name('pelanggan.home');
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');
