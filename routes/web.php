<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\All\CategoryController;
use App\Http\Controllers\All\HomeController;
use App\Http\Controllers\All\RaffleController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

#AUTENTICAÇÃO
Auth::routes();

#SITE ABERTO / SEM MIDDLEWARE
Route::get('/', [HomeController::class, 'index'])->name('home');

// #CONTA DO USUÁRIO FINAL (CONSUMIDOR)
Route::middleware(['auth'])->group(function() {
    #conta de usuário
    Route::get('/account-dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/account-profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/account-profile/update/{user_id}', [UserController::class, 'user_update'])->name('user.update');

    #rifas
    Route::get('/raffles', [RaffleController::class, 'index'])->name('raffle.index');
    Route::get('/raffles/create', [RaffleController::class, 'create'])->name('raffle.create');
    Route::post('/raffles/store', [RaffleController::class, 'store'])->name('raffle.store');
});

// #CONTA DO ADMINISTRADOR
Route::middleware(['auth', AuthAdmin::class])->group(function() {
    // Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    #usuarios
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');

    #categorias
    Route::resource('/categories', CategoryController::class)->names('admin.categories');
    

});