<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\All\CartController;
use App\Http\Controllers\All\CategoryController;
use App\Http\Controllers\All\HomeController;
use App\Http\Controllers\All\RaffleController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\All\CheckoutController;

#AUTENTICAÇÃO
Auth::routes();

#SITE ABERTO / SEM MIDDLEWARE
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home/raffles', [HomeController::class, 'allRaffles'])->name('home.raffles');

// #CONTA DO USUÁRIO FINAL (CONSUMIDOR)
Route::middleware(['auth'])->group(function() {
    #conta de usuário
    Route::get('/account-dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/account-profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/account-profile/update/{user_id}', [UserController::class, 'user_update'])->name('user.update');

    #rifas
    Route::resource('/raffles', RaffleController::class)->names('raffles');
    Route::patch('/raffles/disable/{raffle}', [RaffleController::class, 'disable'])->name('raffles.disable');
    
    #rifa detalhada
    Route::get('/raffle/{raffle_slug}', [HomeController::class, 'show'])->name('raffle.show');

    #carrinho
    Route::post('/cart/add/{raffleId}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::delete('/cart/remove-raffle', [CartController::class, 'removeRaffle'])->name('cart.removeRaffle');

    #checkout
    Route::post('/cart/checkout', [CheckoutController::class, 'finalizePurchase'])->name('checkout.finalize');
    Route::get('/checkout/payment/{orderId}', [CheckoutController::class, 'showPaymentPage'])->name('checkout.payment');
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    Route::post('/webhook/mercadopago', [CheckoutController::class, 'webhook'])->name('webhook.mercadopago');

});

// #CONTA DO ADMINISTRADOR
Route::middleware(['auth', AuthAdmin::class])->group(function() {
    #rotas administrativas
    // Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    #usuarios
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/raffles', [AdminController::class, 'raffles'])->name('admin.raffles');

    #categorias
    Route::resource('/categories', CategoryController::class)->names('admin.categories');
});




