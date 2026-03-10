<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PearlType extends Model
{
       protected $table = 'pearl_types';

    protected $fillable = [
        'name',
        'display_order',
        'is_active',
    ];
}
