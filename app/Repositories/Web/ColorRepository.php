<?php

namespace App\Repositories\Web;
use App\Models\Color;

class ColorRepository{


    public function getAllColor(){
       return Color::latest()->get();
    }

    public function getNameColorById($id){
        return Color::where('id', $id)->value('color');
    }
}
