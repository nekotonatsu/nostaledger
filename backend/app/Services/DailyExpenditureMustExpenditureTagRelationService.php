<?php

namespace App\Services;

use App\Models\DailyExpenditureMustExpenditureTagRelation;
use Illuminate\Database\Eloquent\Collection;

class DailyExpenditureMustExpenditureTagRelationService
{
    public function getAllUserDailyExpenditureMustExpenditureTagRelation(int $userId): Collection
    {
        return DailyExpenditureMustExpenditureTagRelation::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createDailyExpenditureMustExpenditureTagRelation(
        int $userId,
        int $mustExpenditureTagId,
        int $dailyExpenditureId,
    ): DailyExpenditureMustExpenditureTagRelation {
        return DailyExpenditureMustExpenditureTagRelation::create([
            'user_id'                 => $userId,
            'must_expenditure_tag_id' => $mustExpenditureTagId,
            'daily_expenditure_id'    => $dailyExpenditureId,
        ]);
    }

    public function deleteDailyExpenditureMustExpenditureTagRelation(int $id): void
    {
        DailyExpenditureMustExpenditureTagRelation::whereKey($id)->delete();
    }
}
