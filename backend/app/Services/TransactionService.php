<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{
    public function getAll(): Collection
    {
        return Transaction::orderBy('date', 'desc')->get();
    }

    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function update(Transaction $transaction, array $data): Transaction
    {
        $transaction->update($data);

        return $transaction;
    }

    public function delete(Transaction $transaction): void
    {
        $transaction->delete();
    }
}
