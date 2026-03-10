<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoneType extends Model
{
     protected $table = 'stone_types';

    protected $fillable = [
        'name',
        'display_order',
        'is_active',
    ];
}
