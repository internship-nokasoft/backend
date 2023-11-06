<?php

namespace App\Repositories\Web;
use App\Models\Color;

class ColorRepository{

    protected Color $color;

    public function __construct(Color $color){
        $this->color = $color;
    }

    public function getAllColor(){
       return $this->color->latest()->get();
    }

    public function getNameColorById($id){
        return $this->color->where('id', $id)->value('color');
    }
}
