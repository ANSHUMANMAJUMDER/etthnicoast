<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TabSubCategories;
use Illuminate\Support\Str;


class TabCategories extends Model
{
    public function subCategories()
{
    return $this->hasMany(TabSubCategories::class, 'category_id');
}
 protected $fillable = ['name', 'slug', 'display_order', 'is_active'];
 
    protected $casts = ['is_active' => 'boolean'];
 
    // Auto-generate slug on set name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
 
   
 
    public function products()
    {
        return $this->belongsToMany(Product::class, 'tab_category_product', 'tab_category_id', 'product_id');
    }

       public function category()
    {
        return $this->belongsTo(TabCategories::class, 'category_id');
    }

}
