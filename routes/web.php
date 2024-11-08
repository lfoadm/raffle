<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\All\HomeController;
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
    Route::get('/account-dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

// #CONTA DO ADMINISTRADOR
Route::middleware(['auth', AuthAdmin::class])->group(function() {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::get('/lele', function() {
    return view('_home');
});