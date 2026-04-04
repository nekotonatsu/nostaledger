<?php

namespace Tests\Feature\Services;

use App\Models\DailyExpenditure;
use App\Models\User;
use App\Services\DailyExpenditureService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailyExpenditureServiceTest extends TestCase
{
    use RefreshDatabase;

    private DailyExpenditureService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DailyExpenditureService();
    }

    public function test_他ユーザーのデータを返さない(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();

        DailyExpenditure::factory()->count(3)->create(['user_id' => $user->id]);
        DailyExpenditure::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $result = $this->service->getAllUserDailyExpenditure($user->id);

        $this->assertCount(3, $result);
        $result->each(fn ($item) => $this->assertSame($user->id, $item->user_id));
    }

    public function test_登録した支払日順でデータが返されること(): void
    {
        $user = User::factory()->create();

        DailyExpenditure::factory()->create(['user_id' => $user->id, 'expense_at' => '2026-01-01 10:00:00.000']);
        DailyExpenditure::factory()->create(['user_id' => $user->id, 'expense_at' => '2026-03-01 10:00:00.000']);
        DailyExpenditure::factory()->create(['user_id' => $user->id, 'expense_at' => '2026-02-01 10:00:00.000']);

        $result = $this->service->getAllUserDailyExpenditure($user->id);

        $this->assertTrue($result[0]->expense_at->gt($result[1]->expense_at));
        $this->assertTrue($result[1]->expense_at->gt($result[2]->expense_at));
    }

    public function test_DBに問題なくデータが格納されること(): void
    {
        $user      = User::factory()->create();
        $expenseAt = Carbon::parse('2026-04-01 12:00:00.123');

        $result = $this->service->createDailyExpenditure($user->id, '食費', $expenseAt);

        $this->assertInstanceOf(DailyExpenditure::class, $result);
        $this->assertDatabaseHas('daily_expenditures', [
            'user_id'      => $user->id,
            'expense_name' => '食費',
        ]);
    }

    public function test_指定レコードの削除が行える(): void
    {
        $expenditure = DailyExpenditure::factory()->create();

        $this->service->deleteDailyExpenditure($expenditure->id);

        $this->assertDatabaseMissing('daily_expenditures', ['id' => $expenditure->id]);
    }

    public function test_レコードを削除した際他のレコードを削除しない(): void
    {
        $target = DailyExpenditure::factory()->create();
        $other  = DailyExpenditure::factory()->create();

        $this->service->deleteDailyExpenditure($target->id);

        $this->assertDatabaseHas('daily_expenditures', ['id' => $other->id]);
    }
}
