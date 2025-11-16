<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/deposit', [BalanceController::class, 'deposit']);
Route::post('/withdraw', [BalanceController::class, 'withdraw']);
Route::post('/transfer', [BalanceController::class, 'transfer']);
Route::get('/balance/{user_id}', [UserController::class, 'balance']);


