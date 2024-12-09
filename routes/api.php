<?php

use App\Http\Controllers\All\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    // Route::post('/retorno-pagto', [CheckoutController::class, 'handlePixCreated']);
    // Route::post('/retorno-ok', [CheckoutController::class, 'pagamentook']);
});