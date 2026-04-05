<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('must_expenditures', function (Blueprint $table) {
            $table->unsignedInteger('amount')->comment('支出金額（円）')->after('expense_name');
        });
    }

    public function down(): void
    {
        Schema::table('must_expenditures', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
};
