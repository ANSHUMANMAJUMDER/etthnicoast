<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
class OrderTaxDetail extends Model
{
    protected $fillable = [
        'order_id',
        'invoice_id',
        'product_id',
        'sale_date',
        'quantity',
        'unit_price',
        'amount',
        'delivery_state',
        'delivery_cost',
        'cgst_rate',
        'sgst_rate',
        'igst_rate',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'gross_amount',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function order()   { return $this->belongsTo(Order::class); }
    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
