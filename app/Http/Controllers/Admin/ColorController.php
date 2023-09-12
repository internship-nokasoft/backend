<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    protected $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function getAllColors()
    {
        $colors = $this->colorService->getAllColors();
        return response()->json(['data' => $colors]);
    }

    public function destroy($id)
    {
        $color = $this->colorService->getColorById($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found'], 404);
        }

        $this->colorService->deleteColor($color);

        return response()->json(['message' => 'Color deleted successfully']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required|unique:colors',
        ]);

        try {
            $data = $request->only(['color']);
            $color = $this->colorService->createColor($data);
            return response()->json(['message' => 'Color created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create color'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'color' => 'required|unique:colors',
        ]);

        $color = $this->colorService->getColorById($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found'], 404);
        }

        $data = $request->only(['color']);
        $updatedColor = $this->colorService->updateColor($color, $data);

        if ($updatedColor) {
            return response()->json(['message' => 'Color updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Color update failed'], 500);
        }
    }

    public function deleteSelectedColors($ids)
    {
        $colorIds = explode(",", $ids);

        if (empty($colorIds)) {
            return response()->json(['message' => 'No colors selected'], 400);
        }

        $this->colorService->deleteSelectedColors($colorIds);

        return response()->json(['message' => 'Selected colors deleted successfully']);
    }

}
