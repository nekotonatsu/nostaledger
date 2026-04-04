<?php

namespace Database\Factories;

use App\Models\DailyExpenditureTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DailyExpenditure>
 */
class DailyExpenditureTagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'tag_name' => fake()->word()
        ];
    }
}
