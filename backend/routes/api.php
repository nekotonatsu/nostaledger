<?php

use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::apiResource('transactions', TransactionController::class);
Route::get('summary', [SummaryController::class, 'index']);
