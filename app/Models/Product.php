<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_category_id', 'name', 'price', 'image'];

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'product_category_id');
    }
}
