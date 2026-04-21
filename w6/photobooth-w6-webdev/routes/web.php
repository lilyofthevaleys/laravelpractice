<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\SubscriptionController as CustomerSubscriptionController;
use App\Http\Controllers\Admin\PokemonController as AdminPokemonController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\InboxController as AdminInboxController;
use App\Http\Controllers\MidtransWebhookController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

Route::post('/midtrans/notification', [MidtransWebhookController::class, 'notification'])->name('midtrans.notification');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Cart is open to guests (session-based); checkout requires auth.
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{type}/{id}', [CartController::class, 'add'])->whereIn('type', ['pokemon', 'item'])->whereNumber('id')->name('cart.add');
Route::patch('/cart/{type}/{id}', [CartController::class, 'update'])->whereIn('type', ['pokemon', 'item'])->whereNumber('id')->name('cart.update');
Route::delete('/cart/{type}/{id}', [CartController::class, 'remove'])->whereIn('type', ['pokemon', 'item'])->whereNumber('id')->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/{transaction}/pending', [CheckoutController::class, 'pending'])->name('checkout.pending');

    Route::get('/subscribe/{plan}', [CustomerSubscriptionController::class, 'confirm'])->name('subscription.confirm');
    Route::post('/subscribe/{plan}', [CustomerSubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    Route::get('/shop', [AdminPokemonController::class, 'index'])->name('shop.index');
    Route::get('/shop/create', [AdminPokemonController::class, 'create'])->name('shop.create');
    Route::post('/shop', [AdminPokemonController::class, 'store'])->name('shop.store');
    Route::get('/shop/{pokemon}/edit', [AdminPokemonController::class, 'edit'])->name('shop.edit');
    Route::put('/shop/{pokemon}', [AdminPokemonController::class, 'update'])->name('shop.update');
    Route::patch('/shop/{pokemon}/best-seller', [AdminPokemonController::class, 'toggleBestSeller'])->name('shop.toggleBestSeller');
    Route::delete('/shop/{pokemon}', [AdminPokemonController::class, 'destroy'])->name('shop.destroy');

    Route::get('/inbox', [AdminInboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/{message}', [AdminInboxController::class, 'show'])->name('inbox.show');
    Route::patch('/inbox/{message}/unread', [AdminInboxController::class, 'markUnread'])->name('inbox.markUnread');
    Route::delete('/inbox/{message}', [AdminInboxController::class, 'destroy'])->name('inbox.destroy');

    Route::get('/items', [AdminItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [AdminItemController::class, 'create'])->name('items.create');
    Route::post('/items', [AdminItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [AdminItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [AdminItemController::class, 'update'])->name('items.update');
    Route::patch('/items/{item}/best-seller', [AdminItemController::class, 'toggleBestSeller'])->name('items.toggleBestSeller');
    Route::delete('/items/{item}', [AdminItemController::class, 'destroy'])->name('items.destroy');
});
