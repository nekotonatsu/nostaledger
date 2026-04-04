<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_expenditure_daily_expenditure_tag_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id', 'fk_de_det_user')->cascadeOnDelete()->comment('必須出資に関わるタグを登録したユーザーのID');
            $table->foreignId('daily_expenditure_id')
                ->constrained('daily_expenditures', 'id', 'fk_de_det_de')
                ->cascadeOnDelete()
                ->comment('出資ID');
            $table->foreignId('daily_expenditure_tag_id')
                ->constrained('daily_expenditure_tags', 'id', 'fk_de_det_det')
                ->cascadeOnDelete()
                ->comment('出資タグID');
            $table->timestamps();

            $table->index(
                ['user_id', 'daily_expenditure_id', 'daily_expenditure_tag_id'],
                'idx_user_daily_expenditure_daily_enpenditure_tag_relation'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_expenditure_daily_expenditure_tag_relations');
    }
};
