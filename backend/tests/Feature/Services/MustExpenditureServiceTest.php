<?php

namespace Tests\Feature\Services;

use App\Models\MustExpenditure;
use App\Models\User;
use App\Services\MustExpenditureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MustExpenditureServiceTest extends TestCase
{
    use RefreshDatabase;

    private MustExpenditureService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MustExpenditureService();
    }

    public function test_他ユーザーのデータを返さない(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();

        MustExpenditure::factory()->count(3)->create(['user_id' => $user->id]);
        MustExpenditure::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $result = $this->service->getAllUserMustExpenditure($user->id);

        $this->assertCount(3, $result);
        $result->each(fn ($item) => $this->assertSame($user->id, $item->user_id));
    }

    public function test_DBに問題なくデータが格納されること(): void
    {
        $user      = User::factory()->create();

        $result = $this->service->createMustExpenditure($user->id, '食費');

        $this->assertInstanceOf(MustExpenditure::class, $result);
        $this->assertDatabaseHas('must_expenditures', [
            'user_id'      => $user->id,
            'expense_name' => '食費'
        ]);
    }

    public function test_指定レコードの削除が行える(): void
    {
        $expenditure = MustExpenditure::factory()->create();

        $this->service->deleteMustExpenditure($expenditure->id);

        $this->assertDatabaseMissing('must_expenditures', ['id' => $expenditure->id]);
    }

    public function test_レコードを削除した際他のレコードを削除しない(): void
    {
        $target = MustExpenditure::factory()->create();
        $other  = MustExpenditure::factory()->create();

        $this->service->deleteMustExpenditure($target->id);

        $this->assertDatabaseHas('must_expenditures', ['id' => $other->id]);
    }
}

