<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\PolishType;
use App\Models\StoneType;
use App\Models\PearlType;
use App\Models\ProductSimilarItem;
use App\Models\ProductCompleteLook;
use App\Models\Review;
class Product extends Model
{
    protected $fillable = [
        'product_code','base_name','description',
        'quantity','base_price','discount_price','cgst','sgst','weight',
        'stone_type_id','pearl_type_id','polish_type_id','category_id',
        'is_active'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->where('type', 'product');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category() { return $this->belongsTo(Category::class); }
    public function polish() { return $this->belongsTo(PolishType::class, 'polish_type_id'); }
    public function stone()  { return $this->belongsTo(StoneType::class, 'stone_type_id'); }
    public function pearl()  { return $this->belongsTo(PearlType::class, 'pearl_type_id'); }

public function getMainImageAttribute()
{
    return $this->images->first()
        ? asset('public/storage/' . $this->images->first()->image)
        : asset('images/no-image.png');
}

public function similarItems()
{
    return $this->hasMany(ProductSimilarItem::class, 'product_id');
}

public function similarProducts()
{
    return $this->belongsToMany(
        Product::class,
        'product_similar_items',
        'product_id',
        'similar_product_id'
    )->with('images');
}

public function completeLooks()
{
    return $this->hasMany(ProductCompleteLook::class, 'product_id')->orderBy('position');
}
public function completeLookProducts()
{
    return $this->belongsToMany(
        Product::class,
        'product_complete_looks',
        'product_id',
        'look_product_id'
    )->withPivot('position')->orderBy('product_complete_looks.position')->with('images');
}

public function reviews()
{
    return $this->hasMany(Review::class)->latest();
}

public function carts()
{
    return $this->hasMany(Cart::class); 
}


}
