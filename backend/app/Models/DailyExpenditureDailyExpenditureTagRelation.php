<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyExpenditureTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dailyexpendituretag_id',
        'dailyexpenditure_id'
    ];
}