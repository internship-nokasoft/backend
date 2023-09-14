<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $casts =
    [
        'color' => 'json',
        'size' => 'json',
    ];


    protected $fillable = [
        'product_name',
        'category_id',
        'category_name',
        'short_desc',
        'desc',
        'product_img',
        'price',
        'color',
        'size',
        'quantity',
        'slug',
    ];


    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = str_replace(' ','-',$product->product_name);
        });

        static::updating(function ($product) {
            if ($product->isDirty('product_name')) {
                $product->slug = str_replace(' ', '-', $product->product_name);
            }
        });
    }
}
