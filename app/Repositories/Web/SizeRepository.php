<?php

namespace App\Repositories\Web;
use App\Models\Size;

class SizeRepository{

    protected Size $size;

    public function __construct(Size $size){
        $this->size = $size;
    }

    public function getAllSize(){
        return $this->size::latest()->get();
    }

    public function getNameSizeById($id){
        return $this->size::where('id', $id)->value('size_name');
    }

}
