<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TabSubCategories;

class TabCategories extends Model
{
    public function subCategories()
{
    return $this->hasMany(TabSubCategories::class, 'category_id');
}
}
