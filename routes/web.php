<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenjahitController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [SesiController::class, 'showLogin'])->name('login');
    Route::post('/login', [SesiController::class, 'login'])->name('login.action');

    Route::get('/register', [SesiController::class, 'showRegister'])->name('register');
    Route::post('/register', [SesiController::class, 'register'])->name('register.action');
});

Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'roles.admin')->name('admin.dashboard');
    // Route::get('/admin', function () {
    //     return redirect()->route('admin.users');
    // });
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/admin/payments/{payment}/verify', [AdminController::class, 'verifyPayment'])->name('admin.payments.verify');
    
});

Route::middleware(['auth', 'role:penjahit'])->group(function () {
    Route::view('/penjahit', 'roles.penjahit')->name('penjahit.dashboard');
    Route::resource('/products', ProductController::class);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::view('/pelanggan', 'roles.pelanggan')->name('pelanggan.dashboard');
    Route::view('/contact', 'layouts.contact')->name('contact');
    Route::view('/about', 'layouts.about')->name('about');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{product}/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/{product}', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/detail/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/payments/{order}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{order}', [PaymentController::class, 'store'])->name('payments.store');
});

Route::middleware(['auth', 'role:user'])->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('pelanggan.profile');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Route::middleware(['auth', 'role:penjahit'])->prefix('profile')->group(function () {
//     Route::get('/', [ProfileController::class, 'show'])->name('pelanggan.profile');
//     Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
//     Route::get('/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
//     Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
// });

Route::get('/order', function () {
    return view('pelanggan.order');
})->name('pelanggan.home');
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');
