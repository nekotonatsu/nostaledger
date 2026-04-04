<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyExpenditureMustExpenditureTagRelation;
use App\Services\DailyExpenditureMustExpenditureTagRelationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyExpenditureMustExpenditureTagRelationController extends Controller
{
    public function __construct(
        private readonly DailyExpenditureMustExpenditureTagRelationService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->service->getAllUserDailyExpenditureMustExpenditureTagRelation($request->user()->id)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'daily_expenditure_id'    => 'required|integer|exists:daily_expenditures,id',
            'must_expenditure_tag_id' => 'required|integer|exists:must_expenditure_tags,id',
        ]);

        $result = $this->service->createDailyExpenditureMustExpenditureTagRelation(
            $request->user()->id,
            $validated['must_expenditure_tag_id'],
            $validated['daily_expenditure_id'],
        );

        return response()->json($result, 201);
    }

    public function destroy(DailyExpenditureMustExpenditureTagRelation $dailyExpenditureMustExpenditureTagRelation): JsonResponse
    {
        $this->service->deleteDailyExpenditureMustExpenditureTagRelation(
            $dailyExpenditureMustExpenditureTagRelation->id
        );

        return response()->json(null, 204);
    }
}
