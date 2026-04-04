<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DailyExpenditureController;
use App\Http\Controllers\Api\DailyExpenditureDailyExpenditureTagRelationController;
use App\Http\Controllers\Api\DailyExpenditureMustExpenditureTagRelationController;
use App\Http\Controllers\Api\DailyExpenditureTagController;
use App\Http\Controllers\Api\MustExpenditureController;
use App\Http\Controllers\Api\MustExpenditureMustExpenditureTagRelationController;
use App\Http\Controllers\Api\MustExpenditureTagController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('transactions', TransactionController::class);
    Route::get('summary', [SummaryController::class, 'index']);

    Route::apiResource('daily-expenditures', DailyExpenditureController::class)
        ->only(['index', 'store', 'destroy']);

    Route::apiResource('daily-expenditure-tags', DailyExpenditureTagController::class)
        ->only(['index', 'store', 'destroy']);

    Route::apiResource('must-expenditures', MustExpenditureController::class)
        ->only(['index', 'store', 'destroy']);

    Route::apiResource('must-expenditure-tags', MustExpenditureTagController::class)
        ->only(['index', 'store', 'destroy']);

    Route::apiResource(
        'daily-expenditure-daily-expenditure-tag-relations',
        DailyExpenditureDailyExpenditureTagRelationController::class
    )->only(['index', 'store', 'destroy']);

    Route::apiResource(
        'daily-expenditure-must-expenditure-tag-relations',
        DailyExpenditureMustExpenditureTagRelationController::class
    )->only(['index', 'store', 'destroy']);

    Route::apiResource(
        'must-expenditure-must-expenditure-tag-relations',
        MustExpenditureMustExpenditureTagRelationController::class
    )->only(['index', 'store', 'destroy']);
});
