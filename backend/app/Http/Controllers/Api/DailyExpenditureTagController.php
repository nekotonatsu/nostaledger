<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyExpenditureTag;
use App\Services\DailyExpenditureTagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyExpenditureTagController extends Controller
{
    public function __construct(private readonly DailyExpenditureTagService $service) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->service->getAllUserDailyExpenditureTag($request->user()->id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tag_name' => 'required|string|max:255',
        ]);

        $result = $this->service->createDailyExpenditureTag(
            $request->user()->id,
            $validated['tag_name'],
        );

        return response()->json($result, 201);
    }

    public function destroy(DailyExpenditureTag $dailyExpenditureTag): JsonResponse
    {
        $this->service->deleteDailyExpenditureTag($dailyExpenditureTag->id);

        return response()->json(null, 204);
    }
}
