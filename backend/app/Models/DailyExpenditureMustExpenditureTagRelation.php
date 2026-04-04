<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyExpenditureMustExpenditureTagRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'must_expenditure_tag_id',
        'daily_expenditure_id'
    ];
}
