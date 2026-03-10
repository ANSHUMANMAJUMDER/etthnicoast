<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopTheLookHotspots;
class ShopTheLook extends Model
{
   public function hotspots()
    {
        return $this->hasMany(ShopTheLookHotspots::class);
    }
}
