<?php

namespace App\Services;

use App\Models\DailyExpenditureDailyExpenditureTagRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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

    public function getExpendituresWithTag(int $userId): Collection
    {
        return DailyExpenditureDailyExpenditureTagRelation::query()
            ->where('daily_expenditure_daily_expenditure_tag_relations.user_id', $userId)
            ->join('daily_expenditure_tags', 'daily_expenditure_daily_expenditure_tag_relations.daily_expenditure_tag_id', '=', 'daily_expenditure_tags.id')
            ->join('daily_expenditures', 'daily_expenditure_daily_expenditure_tag_relations.daily_expenditure_id', '=', 'daily_expenditures.id')
            ->orderBy('daily_expenditures.expense_at', 'desc')
            ->select([
                'daily_expenditures.expense_name',
                'daily_expenditures.amount',
                'daily_expenditures.expense_at',
                'daily_expenditure_tags.tag_name',
            ])
            ->get();
    }

    public function getAmountGroupByTag(int $userId): Collection
    {
        return DailyExpenditureDailyExpenditureTagRelation::query()
            ->where('daily_expenditure_daily_expenditure_tag_relations.user_id', $userId)
            ->join('daily_expenditure_tags', 'daily_expenditure_daily_expenditure_tag_relations.daily_expenditure_tag_id', '=', 'daily_expenditure_tags.id')
            ->join('daily_expenditures', 'daily_expenditure_daily_expenditure_tag_relations.daily_expenditure_id', '=', 'daily_expenditures.id')
            ->groupBy('daily_expenditure_tags.id', 'daily_expenditure_tags.tag_name')
            ->select([
                'daily_expenditure_tags.id as tag_id',
                'daily_expenditure_tags.tag_name',
                DB::raw('SUM(daily_expenditures.amount) as total_amount'),
            ])
            ->get();
    }
}
