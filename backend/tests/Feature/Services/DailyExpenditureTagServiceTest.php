<?php

namespace Tests\Feature\Services;

use App\Models\DailyExpenditureTag;
use App\Models\User;
use App\Services\DailyExpenditureTagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailyExpenditureTagServiceTest extends TestCase
{
    use RefreshDatabase;

    private DailyExpenditureTagService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DailyExpenditureTagService();
    }

    public function test_他ユーザーのデータを返さない(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();

        DailyExpenditureTag::factory()->count(3)->create(['user_id' => $user->id]);
        DailyExpenditureTag::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $result = $this->service->getAllUserDailyExpenditureTag($user->id);

        $this->assertCount(3, $result);
        $result->each(fn ($item) => $this->assertSame($user->id, $item->user_id));
    }

    public function test_DBに問題なくデータが格納されること(): void
    {
        $user      = User::factory()->create();

        $result = $this->service->createDailyExpenditureTag($user->id, '食費', $expenseAt);

        $this->assertInstanceOf(DailyExpenditure::class, $result);
        $this->assertDatabaseHas('daily_expenditure_tags', [
            'user_id'      => $user->id,
            'tag_name' => '食費',
        ]);
    }

    public function test_指定レコードの削除が行える(): void
    {
        $expenditure = DailyExpenditureTag::factory()->create();

        $this->service->deleteDailyExpenditureTag($expenditure->id);

        $this->assertDatabaseMissing('daily_expenditure_tags', ['id' => $expenditure->id]);
    }

    public function test_レコードを削除した際他のレコードを削除しない(): void
    {
        $target = DailyExpenditure::factory()->create();
        $other  = DailyExpenditure::factory()->create();

        $this->service->deleteDailyExpenditureTag($target->id);

        $this->assertDatabaseHas('daily_expenditure_tags', ['id' => $other->id]);
    }
}

