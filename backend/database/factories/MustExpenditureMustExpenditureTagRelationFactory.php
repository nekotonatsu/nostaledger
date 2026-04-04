<?php

namespace Database\Factories;

use App\Models\MustExpenditureMustExpenditureTagRelation;
use App\Models\User;
use App\Models\MustExpenditure;
use App\Models\MustExpenditureTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MustExpenditureMustExpenditureTagRelation>
 */
class MustExpenditureMustExpenditureTagRelationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'                 => User::factory(),
            'must_expenditure_tag_id' => MustExpenditureTag::factory(),
            'must_expenditure_id'     => MustExpenditure::factory(),
        ];
    }
}
