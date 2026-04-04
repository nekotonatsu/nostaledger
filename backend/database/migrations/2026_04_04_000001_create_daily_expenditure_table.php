<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_expenditures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('支出を記録したユーザーのID');
            $table->string('expense_name')->comment('支出名');
            $table->datetime('expense_at', 3)->comment('支出日時（ミリ秒精度）');
            $table->timestamps();

            $table->index(['user_id', 'expense_name'], 'idx_user_expense_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_expenditures');
    }
};
