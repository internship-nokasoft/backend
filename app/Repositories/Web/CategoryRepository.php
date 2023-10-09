<?php

namespace App\Repositories\Web;

use App\Models\Category;

class CategoryRepository{

    protected Category $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function getAllCategory(){
        return $this->category::latest()->get();
    }

    public function findCategoryById($id){
        return $this->category::findOrFail($id);
    }


}
