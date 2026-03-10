<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;
use App\Models\InvoiceItems;
class Invoice extends Model
{
     protected $fillable = ['invoice_number', 'user_id', 'order_id', 'total_amount'];

    public function items()  { return $this->hasMany(InvoiceItems::class); }
    public function order()  { return $this->belongsTo(Order::class); }
    public function user()   { return $this->belongsTo(User::class); }
}
