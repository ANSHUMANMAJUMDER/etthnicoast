<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabSubCategories extends Model
{
   public function category()
    {
        return $this->belongsTo(TabCategories::class, 'category_id');
    }
}
