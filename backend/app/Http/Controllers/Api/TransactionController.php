<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'type'     => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'date'     => 'required|date',
        ]);

        return response()->json($this->service->create($validated), 201);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return response()->json($transaction);
    }

    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        $validated = $request->validate([
            'title'    => 'sometimes|string|max:255',
            'amount'   => 'sometimes|numeric|min:0',
            'type'     => 'sometimes|in:income,expense',
            'category' => 'sometimes|string|max:100',
            'date'     => 'sometimes|date',
        ]);

        return response()->json($this->service->update($transaction, $validated));
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        $this->service->delete($transaction);

        return response()->json(null, 204);
    }
}
