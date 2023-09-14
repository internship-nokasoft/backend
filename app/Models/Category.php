<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_name',
        'product_cout',
        'slug',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = str_replace(' ','-',$category->category_name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('category_name')) {
                $category->slug = str_replace(' ', '-', $category->category_name);
            }
        });
    }
}
