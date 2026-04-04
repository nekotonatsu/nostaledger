<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('must_expenditure_must_expenditure_tag_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('必須出資に関わるタグを登録したユーザーのID');
            $table->foreignId('must_expenditure_id')
                ->constrained('must_expenditures', 'id', 'fk_me_met_me')
                ->cascadeOnDelete()
                ->comment('必須出資ID');
            $table->foreignId('must_expenditure_tag_id')
                ->constrained('must_expenditure_tags', 'id', 'fk_me_met_met')
                ->cascadeOnDelete()
                ->comment('必須出資タグID');
            $table->timestamps();

            $table->index(
                ['user_id', 'must_expenditure_id', 'must_expenditure_tag_id'],
                'idx_user_must_expenditure_enpenditure_tag_relation'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('must_expenditure_must_expenditure_tag_relations');
    }
};
