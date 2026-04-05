<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MustExpenditureTag;
use App\Services\MustExpenditureTagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MustExpenditureTagController extends Controller
{
    public function __construct(private readonly MustExpenditureTagService $service) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->service->getAllUserMustExpenditureTag($request->user()->id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tag_name' => 'required|string|max:255',
        ]);

        $result = $this->service->createMustExpenditureTag(
            $request->user()->id,
            $validated['tag_name'],
        );

        return response()->json($result, 201);
    }

    public function destroy(MustExpenditureTag $mustExpenditureTag): JsonResponse
    {
        $this->service->deleteMustExpenditureTag($mustExpenditureTag->id);

        return response()->json(null, 204);
    }
}
