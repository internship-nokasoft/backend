<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    protected $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function getAllSizes()
    {
        $sizes = $this->sizeService->getAllSizes();
        return response()->json(['data' => $sizes]);
    }

    public function destroy($id)
    {
        $size = $this->sizeService->getSizeById($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        $this->sizeService->deleteSize($size);

        return response()->json(['message' => 'Size deleted successfully']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'size_name' => 'required|unique:sizes',
        ]);

        try {
            $data = $request->only(['size_name']);
            $size = $this->sizeService->createSize($data);
            return response()->json(['message' => 'Size created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create size'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'size_name' => 'required|unique:sizes',
        ]);

        $size = $this->sizeService->getSizeById($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        $data = $request->only(['size_name']);
        $updatedSize = $this->sizeService->updateSize($size, $data);

        if ($updatedSize) {
            return response()->json(['message' => 'Size updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Size update failed'], 500);
        }
    }

    public function deleteSelectedSizes($ids)
    {
        $sizeIds = explode(",", $ids);

        if (empty($sizeIds)) {
            return response()->json(['message' => 'No sizes selected'], 400);
        }

        $this->sizeService->deleteSelectedSizes($sizeIds);

        return response()->json(['message' => 'Selected sizes deleted successfully']);
    }
}
