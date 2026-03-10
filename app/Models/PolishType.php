<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolishType extends Model
{
     protected $table = 'polish_types';

    protected $fillable = [
        'name',
        'display_order',
        'color_code',
        'is_active',
    ];
}
