<?php

namespace App\Services\Api;

use App\Repositories\Api\SizeRepository;

class SizeService
{
    protected SizeRepository $sizeRepository;

    public function __construct(SizeRepository $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    public function getAllSizes()
    {
        return $this->sizeRepository->all();
    }

    public function createSize($data)
    {
        return $this->sizeRepository->create($data);
    }

    public function updateSize($size, $data)
    {
        return $this->sizeRepository->update($size, $data);
    }

    public function getSizeById($id){
        return $this->sizeRepository->find($id);
    }

    public function deleteSize($size)
    {
        $this->sizeRepository->delete($size);
    }

    public function deleteSelectedSizes(array $sizeIds)
    {
        $this->sizeRepository->deleteSelectedSizes($sizeIds);
    }

    
}
