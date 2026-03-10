<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\User;
use App\Models\OrderTaxDetail;
class Order extends Model
{
     protected $fillable = ['order_code', 'user_id', 'total_amount', 'status'];

    public function items()     { return $this->hasMany(OrderItem::class); }
    public function invoice()   { return $this->hasOne(Invoice::class); }
    public function user()      { return $this->belongsTo(User::class); }

    public function taxDetail()
{
    return $this->hasOne(OrderTaxDetail::class);
}
}
