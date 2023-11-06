<?php

namespace App\Repositories\Api;

use App\Models\Color;

class ColorRepository
{

    protected Color $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }
    public function all()
    {
        return $this->color->latest()->get();
    }

    public function find($id)
    {
        return $this->color->find($id);
    }

    public function create($data)
    {
        return $this->color->create($data);
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
        $this->color->whereIn('id', $colorIds)->forceDelete();
    }
}