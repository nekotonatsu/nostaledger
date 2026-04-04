<?php

namespace App\Services;

use App\Models\DailyExpenditure;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class DailyExpenditureService
{
    public function getAllUserDailyExpenditure(int $userId): Collection
    {
        return DailyExpenditure::where('user_id', $userId)
            ->orderBy('expense_at', 'desc')
            ->get();
    }

    public function createDailyExpenditure(
        int $userId,
        string $expenseName,
        Carbon $expenseAt
    ): DailyExpenditure {
        return DailyExpenditure::create([
            'user_id'      => $userId,
            'expense_name' => $expenseName,
            'expense_at'   => $expenseAt,
        ]);
    }

    public function deleteDailyExpenditure(int $id): void
    {
        DailyExpenditure::whereKey($id)->delete();
    }
}