<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
 protected $fillable = [
        'category_type_id',
        'category_name',
        'description',
        'status'
    ];

    public function type()
    {
        return $this->belongsTo(CategoryTypes::class, 'category_type_id');
    }
}
