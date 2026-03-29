<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
        protected $fillable = ['user_id', 'product_id', 'variant_id', 'quantity'];

   public function items()
    {
        return $this->hasMany(CartItem::class);
    }
 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
      public function product()
    {
        return $this->belongsTo(Product::class)->with('images');
    }
 
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
 
   
 
    // ── Helpers ───────────────────────────────────────────────────────────
    public function getSubtotalAttribute(): float
    {
        return $this->product->base_price * $this->quantity;
    }
}
