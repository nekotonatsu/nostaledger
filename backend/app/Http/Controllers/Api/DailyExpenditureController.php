<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyExpenditure;
use App\Services\DailyExpenditureService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyExpenditureController extends Controller
{
    public function __construct(private readonly DailyExpenditureService $service) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->service->getAllUserDailyExpenditure($request->user()->id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'expense_name' => 'required|string|max:255',
            'expense_at'   => 'required|date',
        ]);

        $result = $this->service->createDailyExpenditure(
            $request->user()->id,
            $validated['expense_name'],
            Carbon::parse($validated['expense_at']),
        );

        return response()->json($result, 201);
    }

    public function destroy(DailyExpenditure $dailyExpenditure): JsonResponse
    {
        $this->service->deleteDailyExpenditure($dailyExpenditure->id);

        return response()->json(null, 204);
    }
}
