<?php

namespace App\Repositories\Api;
use App\Models\Color;

class ColorRepository{
    public function all()
    {
        return Color::latest()->get();
    }

    public function find($id)
    {
        return Color::find($id);
    }

    public function create($data)
    {
        return Color::create($data);
    }

    public function update($color, $data)
    {
        $color->update($data);
        return $color;
    }

    public function delete($color)
    {
        $color->forceDelete();
    }

    public function deleteSelectedColors(array $colorIds)
    {
        Color::whereIn('id', $colorIds)->forceDelete();
    }
}