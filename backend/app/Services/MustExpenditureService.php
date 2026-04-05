<?php

namespace App\Services;

use App\Models\MustExpenditure;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class MustExpenditureService
{
    public function getAllUserMustExpenditure(int $userId): Collection
    {
        return MustExpenditure::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createMustExpenditure(
        int $userId,
        string $expenseName,
        int $amount
    ): MustExpenditure {
        return MustExpenditure::create([
            'user_id'      => $userId,
            'expense_name' => $expenseName,
            'amount'       => $amount,
        ]);
    }

    public function deleteMustExpenditure(int $id): void
    {
        MustExpenditure::whereKey($id)->delete();
    }
}