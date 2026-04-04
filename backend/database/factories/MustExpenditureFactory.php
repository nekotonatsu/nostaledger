<?php

namespace Database\Factories;

use App\Models\MustExpenditure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MustExpenditure>
 */
class MustExpenditureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'expense_name' => fake()->word()
        ];
    }
}
