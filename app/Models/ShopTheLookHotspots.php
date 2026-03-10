<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopTheLookHotspots extends Model
{
   protected $fillable = ['shop_the_look_id', 'product_id', 'x_coordinate', 'y_coordinate', 'is_active'];

    public function shopTheLook()
    {
        return $this->belongsTo(ShopTheLook::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
