<?php

namespace App\Repositories\Web;

use App\Models\Category;

class CategoryRepository{


    public function getAllCategory(){
        return Category::latest()->get();
    }

    public function findCategoryById($id){
        return Category::findOrFail($id);
    }


}
