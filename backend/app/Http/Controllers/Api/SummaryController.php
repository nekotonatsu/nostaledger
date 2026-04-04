<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class SummaryController extends Controller
{
    public function index(): JsonResponse
    {
        $income  = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');

        return response()->json([
            'income'  => (float) $income,
            'expense' => (float) $expense,
            'balance' => (float) ($income - $expense),
        ]);
    }
}
