<?php

namespace App\Services;

use App\Models\MustExpenditureTag;
use Illuminate\Database\Eloquent\Collection;

class MustExpenditureTagService
{
    public function getAllUserMustExpenditureTag(int $userId): Collection
    {
        return MustExpenditureTag::where('user_id', $userId)
            ->get();
    }

    public function createMustExpenditureTag(
        int $userId,
        string $tagName,
    ): MustExpenditureTag {
        return MustExpenditureTag::create([
            'user_id'      => $userId,
            'tag_name' => $tagName
        ]);
    }

    public function deleteMustExpenditureTag(int $id): void
    {
        MustExpenditureTag::whereKey($id)->delete();
    }
}