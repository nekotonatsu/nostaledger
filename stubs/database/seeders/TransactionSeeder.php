<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['title' => '給与', 'amount' => 300000, 'type' => 'income', 'category' => '給与', 'date' => '2024-01-25'],
            ['title' => '副業収入', 'amount' => 50000, 'type' => 'income', 'category' => '副業', 'date' => '2024-01-20'],
            ['title' => '家賃', 'amount' => 80000, 'type' => 'expense', 'category' => '住居', 'date' => '2024-01-01'],
            ['title' => 'スーパー', 'amount' => 12000, 'type' => 'expense', 'category' => '食費', 'date' => '2024-01-10'],
            ['title' => 'ランチ', 'amount' => 3500, 'type' => 'expense', 'category' => '食費', 'date' => '2024-01-15'],
            ['title' => '電気代', 'amount' => 8000, 'type' => 'expense', 'category' => '光熱費', 'date' => '2024-01-05'],
            ['title' => '交通費', 'amount' => 15000, 'type' => 'expense', 'category' => '交通', 'date' => '2024-01-12'],
        ];

        foreach ($samples as $sample) {
            Transaction::create($sample);
        }
    }
}
