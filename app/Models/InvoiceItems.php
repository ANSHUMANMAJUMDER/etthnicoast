<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductVariant;

class InvoiceItems extends Model
{
    protected $fillable = [
        'invoice_id', 'product_id', 'variant_id',
        'quantity', 'price', 'total_price', 'cgst', 'sgst'
    ];

    public function product() { return $this->belongsTo(Product::class); }
    public function variant() { return $this->belongsTo(ProductVariant::class); }
}
