<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carts';
    protected $fillable = ['user_id', 'product_id', 'size', 'color', 'quantity'];


    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}