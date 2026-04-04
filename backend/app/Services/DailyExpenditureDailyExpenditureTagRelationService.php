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
        int $dailyexpendituretagId,
        int $dailyexpenditureId,
    ): DailyExpenditureDailyExpenditureTagRelation {
        return DailyExpenditureDailyExpenditureTagRelation::create([
            'user_id'      => $userId,
            'dailyexpendituretag_id' => $dailyexpendituretagId,
            'dailyexpenditure_id'   => $dailyexpenditureId,
        ]);
    }

    public function deleteDailyExpenditureDailyExpenditureTagRelation(int $id): void
    {
        DailyExpenditureDailyExpenditureTagRelation::whereKey($id)->delete();
    }
}