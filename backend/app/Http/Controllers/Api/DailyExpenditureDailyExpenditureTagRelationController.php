<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyExpenditureDailyExpenditureTagRelation;
use App\Services\DailyExpenditureDailyExpenditureTagRelationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyExpenditureDailyExpenditureTagRelationController extends Controller
{
    public function __construct(
        private readonly DailyExpenditureDailyExpenditureTagRelationService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->service->getAllUserDailyExpenditureDailyExpenditureTagRelation($request->user()->id)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'daily_expenditure_id'     => 'required|integer|exists:daily_expenditures,id',
            'daily_expenditure_tag_id' => 'required|integer|exists:daily_expenditure_tags,id',
        ]);

        $result = $this->service->createDailyExpenditureDailyExpenditureTagRelation(
            $request->user()->id,
            $validated['daily_expenditure_tag_id'],
            $validated['daily_expenditure_id'],
        );

        return response()->json($result, 201);
    }

    public function destroy(DailyExpenditureDailyExpenditureTagRelation $dailyExpenditureDailyExpenditureTagRelation): JsonResponse
    {
        $this->service->deleteDailyExpenditureDailyExpenditureTagRelation(
            $dailyExpenditureDailyExpenditureTagRelation->id
        );

        return response()->json(null, 204);
    }
}
