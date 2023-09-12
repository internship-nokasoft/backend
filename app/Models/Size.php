<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'size_name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($size) {
            $size->slug = str_replace(' ','-',$size->size_name);
        });

        static::updating(function ($size) {
            if ($size->isDirty('size_name')) {
                $size->slug = str_replace(' ', '-', $size->size_name);
            }
        });
    }
}
