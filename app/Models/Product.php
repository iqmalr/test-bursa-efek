<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['uuid', 'product_category_id', 'name', 'price', 'image'];
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->uuid = Str::uuid();
        });
    }
    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'product_category_id');
    }
}
