<?php

namespace Database\Factories;

use App\Models\DailyExpenditureDailyExpenditureTagRelation;
use App\Models\User;
use App\Models\DailyExpenditure;
use App\Models\DailyExpenditureTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DailyExpenditureDailyExpenditureTagRelation>
 */
class DailyExpenditureDailyExpenditureTagRelationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'                  => User::factory(),
            'daily_expenditure_tag_id' => DailyExpenditureTag::factory(),
            'daily_expenditure_id'     => DailyExpenditure::factory(),
        ];
    }
}
