<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_products';
    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}
