<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('must_expenditures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('必須出資を登録したユーザーのID');
            $table->string('expense_name')->comment('必須出資名');
            $table->timestamps();

            $table->index(['user_id', 'tag_name'], 'idx_user_expense_tag_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('must_expenditures');
    }
};
