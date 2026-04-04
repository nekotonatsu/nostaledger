<?php

namespace App\Services;

use App\Models\DailyExpenditureTag;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class DailyExpenditureTagService
{
    public function getAllUserDailyExpenditureTag(int $userId): Collection
    {
        return DailyExpenditureTag::where('user_id', $userId)
            ->get();
    }

    public function createDailyExpenditureTag(
        int $userId,
        string $tagName,
    ): DailyExpenditureTag {
        return DailyExpenditureTag::create([
            'user_id'      => $userId,
            'tag_name' => $tagName
        ]);
    }

    public function deleteDailyExpenditureTag(int $id): void
    {
        DailyExpenditureTag::whereKey($id)->delete();
    }
}