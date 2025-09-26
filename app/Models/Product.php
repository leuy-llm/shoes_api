<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'img', 'prev_price', 'new_price', 'rating', 'reviews', 'company', 'brand', 'color', 'category'
    ];
}
