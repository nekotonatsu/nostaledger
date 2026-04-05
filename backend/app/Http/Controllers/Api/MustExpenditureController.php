<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MustExpenditure;
use App\Services\MustExpenditureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MustExpenditureController extends Controller
{
    public function __construct(private readonly MustExpenditureService $service) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->service->getAllUserMustExpenditure($request->user()->id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'expense_name' => 'required|string|max:255',
            'amount'       => 'required|integer|min:0',
        ]);

        $result = $this->service->createMustExpenditure(
            $request->user()->id,
            $validated['expense_name'],
            $validated['amount'],
        );

        return response()->json($result, 201);
    }

    public function destroy(MustExpenditure $mustExpenditure): JsonResponse
    {
        $this->service->deleteMustExpenditure($mustExpenditure->id);

        return response()->json(null, 204);
    }
}
