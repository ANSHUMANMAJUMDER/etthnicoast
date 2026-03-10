<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{  protected $fillable = [
        'product_id','product_code',
        'polish_type_id','stone_type_id','pearl_type_id',
        'quantity','base_price','discount_price','cgst','sgst','weight'
    ];

    public function product() { return $this->belongsTo(Product::class); }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'variant_id')->where('type', 'product_variant');
    }
    

    public function polish() { return $this->belongsTo(PolishType::class, 'polish_type_id'); }
    public function stone()  { return $this->belongsTo(StoneType::class, 'stone_type_id'); }
    public function pearl()  { return $this->belongsTo(PearlType::class, 'pearl_type_id'); }
}
