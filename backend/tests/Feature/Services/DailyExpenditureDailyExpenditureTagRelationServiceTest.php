<?php

namespace Tests\Feature\Services;

use App\Models\DailyExpenditureDailyExpenditureTagRelation;
use App\Models\User;
use App\Models\DailyExpenditure;
use App\Models\DailyExpenditureTag;
use App\Services\DailyExpenditureDailyExpenditureTagRelationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailyExpenditureDailyExpenditureTagRelationServiceTest extends TestCase
{
    use RefreshDatabase;

    private DailyExpenditureDailyExpenditureTagRelationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DailyExpenditureDailyExpenditureTagRelationService();
    }

    public function test_他ユーザーのデータを返さない(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();
        $userDailyExpenditure = DailyExpenditure::factory(['user_id' => $user->id]);
        $otherUserDailyExpenditure = DailyExpenditure::factory(['user_id' => $otherUser->id]);
        $userDailyExpenditureTag = DailyExpenditureTag::factory(['user_id' => $user->id]);
        $otherUserDailyExpenditureTag = DailyExpendituretag::factory(['user_id' => $otherUser->id]);

        DailyExpenditureDailyExpenditureTagRelation::factory(
            [
                'user_id' => $user->id,
                'dailyexpenditure_id' => $userDailyExpenditure->id,
                'dailyexpendituretag_id' => $userDailyExpenditureTag->id
            ]
        );
        DailyExpenditureDailyExpenditureTagRelation::factory(
            [
                'user_id' => $otherUser->id,
                'dailyexpenditure_id' => $otherUserDailyExpenditure->id,
                'dailyexpendituretag_id' => $otherUserDailyExpenditureTag->id
            ]
        );

        $result = $this->service->getAllUserDailyExpenditureDailyExpenditureTagRelation($user->id);

        $result->each(fn ($item) => $this->assertSame($user->id, $item->user_id));
    }
}

