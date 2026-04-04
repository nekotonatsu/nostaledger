<?php

namespace Database\Factories;

use App\Models\MustExpenditureTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MustExpenditureTag>
 */
class MustExpenditureTagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'tag_name' => fake()->word()
        ];
    }
}
