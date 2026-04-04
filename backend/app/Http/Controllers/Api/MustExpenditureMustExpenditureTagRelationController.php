<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MustExpenditureMustExpenditureTagRelation;
use App\Services\MustExpenditureMustExpenditureTagRelationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MustExpenditureMustExpenditureTagRelationController extends Controller
{
    public function __construct(
        private readonly MustExpenditureMustExpenditureTagRelationService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->service->getAllUserMustExpenditureMustExpenditureTagRelation($request->user()->id)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'must_expenditure_id'     => 'required|integer|exists:must_expenditures,id',
            'must_expenditure_tag_id' => 'required|integer|exists:must_expenditure_tags,id',
        ]);

        $result = $this->service->createMustExpenditureMustExpenditureTagRelation(
            $request->user()->id,
            $validated['must_expenditure_tag_id'],
            $validated['must_expenditure_id'],
        );

        return response()->json($result, 201);
    }

    public function destroy(MustExpenditureMustExpenditureTagRelation $mustExpenditureMustExpenditureTagRelation): JsonResponse
    {
        $this->service->deleteMustExpenditureMustExpenditureTagRelation(
            $mustExpenditureMustExpenditureTagRelation->id
        );

        return response()->json(null, 204);
    }
}
