<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductCompleteLook extends Model
{
    protected $table = 'product_complete_looks';
    protected $fillable = ['product_id', 'look_product_id', 'position'];
    public function lookProduct()
    {
        return $this->belongsTo(Product::class, 'look_product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->where('type', 'product');
    }
}
