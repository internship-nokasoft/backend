<?php

namespace App\Repositories\Web;
use App\Models\Size;

class SizeRepository{


    public function getAllSize(){
        return Size::latest()->get();
    }

    public function getNameSizeById($id){
        return Size::where('id', $id)->value('size_name');
    }

}
