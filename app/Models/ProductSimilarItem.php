<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSimilarItem extends Model
{
    protected $table = 'product_similar_items';
    protected $fillable = ['product_id', 'similar_product_id'];
     public function similarProduct()
    {
        return $this->belongsTo(Product::class, 'similar_product_id');
    }


}
