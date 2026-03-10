<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Review extends Model
{
      protected $fillable = ['product_id', 'name', 'title', 'message', 'rating'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
