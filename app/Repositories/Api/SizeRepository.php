<?php

namespace App\Repositories\Api;

use App\Models\Size;

class SizeRepository
{

    protected Size $size;

    public function __construct(Size $size){
        $this->size = $size;
    }
    public function all()
    {
        return $this->size->latest()->get();
    }

    public function find($id)
    {
        return $this->size->find($id);
    }

    public function create($data)
    {
        return $this->size->create($data);
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
        $this->size->whereIn('id', $sizeIds)->forceDelete();
    }

}
