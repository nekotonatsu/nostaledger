<?php

namespace App\Services;

use App\Models\DailyExpenditureDailyExpenditureTagRelation;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class DailyExpenditureDailyExpenditureTagRelationService
{
    public function getAllUserDailyExpenditureDailyExpenditureTagRelation(int $userId): Collection
    {
        return DailyExpenditureDailyExpenditureTagRelation::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createDailyExpenditureDailyExpenditureTagRelation(
        int $userId,
        int $dailyExpenditureTagId,
        int $dailyExpenditureId,
    ): DailyExpenditureDailyExpenditureTagRelation {
        return DailyExpenditureDailyExpenditureTagRelation::create([
            'user_id'                  => $userId,
            'daily_expenditure_tag_id' => $dailyExpenditureTagId,
            'daily_expenditure_id'     => $dailyExpenditureId,
        ]);
    }

    public function deleteDailyExpenditureDailyExpenditureTagRelation(int $id): void
    {
        DailyExpenditureDailyExpenditureTagRelation::whereKey($id)->delete();
    }
}
