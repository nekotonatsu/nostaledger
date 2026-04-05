<?php

namespace Database\Factories;

use App\Models\DailyExpenditure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DailyExpenditure>
 */
class DailyExpenditureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'expense_name' => fake()->word(),
            'amount'       => fake()->numberBetween(100, 100000),
            'expense_at'   => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
