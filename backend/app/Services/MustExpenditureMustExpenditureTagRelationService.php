<?php

namespace App\Services;

use App\Models\MustExpenditureMustExpenditureTagRelation;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class MustExpenditureMustExpenditureTagRelationService
{
    public function getAllUserMustExpenditureMustExpenditureTagRelation(int $userId): Collection
    {
        return MustExpenditureMustExpenditureTagRelation::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createMustExpenditureMustExpenditureTagRelation(
        int $userId,
        int $mustExpenditureTagId,
        int $mustExpenditureId,
    ): MustExpenditureMustExpenditureTagRelation {
        return MustExpenditureMustExpenditureTagRelation::create([
            'user_id'      => $userId,
            'mustexpendituretag_id' => $mustExpenditureTagId,
            'mustexpenditure_id'   => $mustExpenditureId,
        ]);
    }

    public function deleteMustExpenditureMustExpenditureTagRelation(int $id): void
    {
        MustExpenditureMustExpenditureTagRelation::whereKey($id)->delete();
    }
}