<?php

namespace App\Services;

use App\Models\DailyExpenditureMustExpenditureTagRelation;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class DailyExpenditureMustExpenditureTagRelationService
{
    public function getAllUserDailyExpenditureMustExpenditureTagRelation(int $userId): Collection
    {
        return DailyExpenditureDailyExpenditureTagRelation::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createDailyExpenditureMustExpenditureTagRelation(
        int $userId,
        int $mustExpenditureTagId,
        int $dailyExpenditureId,
    ): DailyExpenditureMustExpenditureTagRelation {
        return DailyExpenditureMustExpenditureTagRelation::create([
            'user_id'      => $userId,
            'mustexpendituretag_id' => $mustExpenditureTagId,
            'dailyexpenditure_id'   => $dailyExpenditureId,
        ]);
    }

    public function deleteDailyExpenditureMustExpenditureTagRelation(int $id): void
    {
        DailyExpenditureMustExpenditureTagRelatio::whereKey($id)->delete();
    }
}