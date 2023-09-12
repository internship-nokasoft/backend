<?php

namespace App\Repositories\Api;

use App\Models\Size;

class SizeRepository
{
    public function all()
    {
        return Size::latest()->get();
    }

    public function find($id)
    {
        return Size::find($id);
    }

    public function create($data)
    {
        return Size::create($data);
    }

    public function update($size, $data)
    {
        $size->update($data);
        return $size;
    }

    public function delete($size)
    {
        $size->forceDelete();
    }

    public function deleteSelectedSizes(array $sizeIds)
    {
        Size::whereIn('id', $sizeIds)->forceDelete();
    }

}
