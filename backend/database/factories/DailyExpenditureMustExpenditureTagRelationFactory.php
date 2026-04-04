<?php

namespace Database\Factories;

use App\Models\DailyExpenditureMustExpenditureTagRelation;
use App\Models\User;
use App\Models\DailyExpenditure;
use App\Models\MustExpenditureTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DailyExpenditureMustExpenditureTagRelation>
 */
class DailyExpenditureMustExpenditureTagRelationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'                 => User::factory(),
            'must_expenditure_tag_id' => MustExpenditureTag::factory(),
            'daily_expenditure_id'    => DailyExpenditure::factory(),
        ];
    }
}
