<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyExpenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expense_name',
        'expense_at',
    ];

    protected $casts = [
        'expense_at' => 'datetime:Y-m-d H:i:s.v',
    ];
}