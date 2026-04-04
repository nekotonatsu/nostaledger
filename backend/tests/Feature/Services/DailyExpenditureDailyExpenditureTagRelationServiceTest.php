<?php

namespace Tests\Feature\Services;

use App\Models\DailyExpenditureDailyExpenditureTagRelation;
use App\Models\User;
use App\Models\DailyExpenditure;
use App\Models\DailyExpenditureTag;
use App\Services\DailyExpenditureDailyExpenditureTagRelationService;
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
        $userDailyExpenditure      = DailyExpenditure::factory()->create(['user_id' => $user->id]);
        $otherUserDailyExpenditure = DailyExpenditure::factory()->create(['user_id' => $otherUser->id]);
        $userDailyExpenditureTag      = DailyExpenditureTag::factory()->create(['user_id' => $user->id]);
        $otherUserDailyExpenditureTag = DailyExpenditureTag::factory()->create(['user_id' => $otherUser->id]);

        DailyExpenditureDailyExpenditureTagRelation::factory()->create([
            'user_id'                  => $user->id,
            'daily_expenditure_id'     => $userDailyExpenditure->id,
            'daily_expenditure_tag_id' => $userDailyExpenditureTag->id,
        ]);
        DailyExpenditureDailyExpenditureTagRelation::factory()->create([
            'user_id'                  => $otherUser->id,
            'daily_expenditure_id'     => $otherUserDailyExpenditure->id,
            'daily_expenditure_tag_id' => $otherUserDailyExpenditureTag->id,
        ]);

        $result = $this->service->getAllUserDailyExpenditureDailyExpenditureTagRelation($user->id);

        $result->each(fn ($item) => $this->assertSame($user->id, $item->user_id));
    }
}
