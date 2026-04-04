<?php

namespace Tests\Feature\Services;

use App\Models\MustExpenditureTag;
use App\Models\User;
use App\Services\MustExpenditureTagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MustExpenditureTagServiceTest extends TestCase
{
    use RefreshDatabase;

    private MustExpenditureTagService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MustExpenditureTagService();
    }

    public function test_他ユーザーのデータを返さない(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();

        MustExpenditureTag::factory()->count(3)->create(['user_id' => $user->id]);
        MustExpenditureTag::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $result = $this->service->getAllUserMustExpenditureTag($user->id);

        $this->assertCount(3, $result);
        $result->each(fn ($item) => $this->assertSame($user->id, $item->user_id));
    }

    public function test_DBに問題なくデータが格納されること(): void
    {
        $user      = User::factory()->create();

        $result = $this->service->createMustExpenditureTag($user->id, '食費');

        $this->assertInstanceOf(MustExpenditureTag::class, $result);
        $this->assertDatabaseHas('must_expenditure_tags', [
            'user_id'      => $user->id,
            'tag_name' => '食費',
        ]);
    }

    public function test_指定レコードの削除が行える(): void
    {
        $expenditure = MustExpenditureTag::factory()->create();

        $this->service->deleteMustExpenditureTag($expenditure->id);

        $this->assertDatabaseMissing('must_expenditure_tags', ['id' => $expenditure->id]);
    }

    public function test_レコードを削除した際他のレコードを削除しない(): void
    {
        $target = MustExpenditureTag::factory()->create();
        $other  = MustExpenditureTag::factory()->create();

        $this->service->deleteMustExpenditureTag($target->id);

        $this->assertDatabaseHas('must_expenditure_tags', ['id' => $other->id]);
    }
}

