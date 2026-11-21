
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/produk', [PageController::class, 'products'])->name('products');
Route::post('/produk/{id}/favorit', [PageController::class, 'toggleFav'])->name('fav');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PageController::class, 'sendMessage'])->name('contact.send');

// Keranjang dan checkout
Route::post('/keranjang/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/keranjang/{index}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'place'])->name('checkout.place');
Route::get('/checkout/bayar/{number}', [CartController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/sukses/{number}', [CartController::class, 'success'])->name('checkout.success');

// Midtrans
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');

// Login dan register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')->middleware('auth');

// Kontak
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

// Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Pesan masuk
    Route::get('/messages', [AdminController::class, 'messages'])
        ->name('messages');

    Route::get('/messages/{id}', [AdminController::class, 'readMessage'])
        ->name('messages.read');

    Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage'])
        ->name('messages.delete');

    // Manajemen Produk
    Route::resource('/products', ProductController::class);

    // Manajemen Stok
    Route::get('/stock', [AdminStockController::class, 'index'])
        ->name('stock');

    Route::put('/stock/{id}', [AdminStockController::class, 'update'])
        ->name('stock.update');

});
