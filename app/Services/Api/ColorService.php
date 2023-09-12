<?php 

namespace App\Services\Api;
use App\Repositories\Api\ColorRepository;


class ColorService{
    protected $colorRepository;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    public function getAllColors()
    {
        return $this->colorRepository->all();
    }

    public function createColor($data)
    {
        return $this->colorRepository->create($data);
    }

    public function updateColor($color, $data)
    {
        return $this->colorRepository->update($color, $data);
    }

    public function getColorById($id){
        return $this->colorRepository->find($id);
    }

    public function deleteColor($color)
    {
        $this->colorRepository->delete($color);
    }

    public function deleteSelectedColors(array $colorIds)
    {
        $this->colorRepository->deleteSelectedColors($colorIds);
    }
}