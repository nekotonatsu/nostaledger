<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MustExpenditureMustExpenditureTagRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mustexpendituretag_id',
        'mustexpenditure_id'
    ];
}