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
            'user_id' => User::factory(),
            'dailyexpendituretag_id' => DailyExpenditureTag::factory(),
            'dailyexpenditure_id' => DailyExpenditure::factory(),
        ];
    }
}
