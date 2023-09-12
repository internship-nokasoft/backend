<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'color',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($color) {
            $color->slug = str_replace(' ','-',$color->color);
        });

        static::updating(function ($color) {
            if ($color->isDirty('color')) {
                $color->slug = str_replace(' ', '-', $color->color);
            }
        });
    }
}
