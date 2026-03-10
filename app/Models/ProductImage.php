<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
   protected $fillable = ['product_id','variant_id','type','image'];

    public function product() { return $this->belongsTo(Product::class); }
    public function variant() { return $this->belongsTo(ProductVariant::class, 'variant_id'); }

public function getUrlAttribute()
{
    return asset('public/storage/' . $this->image);
}
    }
