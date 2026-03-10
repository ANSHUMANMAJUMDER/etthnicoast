<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_tax_details', function (Blueprint $table) {
            $table->id();
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

        // ── Sale Info ─────────────────────────────────────────
        $table->date('sale_date');
        $table->integer('quantity')->default(1);
        $table->decimal('unit_price', 10, 2);        // price per item
        $table->decimal('amount', 10, 2);            // unit_price * quantity

        // ── Delivery ──────────────────────────────────────────
        $table->string('delivery_state')->nullable();
        $table->decimal('delivery_cost', 10, 2)->default(0);

        // ── GST (rates pulled from products table) ────────────
        $table->decimal('cgst_rate', 5, 2)->default(0);   // e.g. 1.5
        $table->decimal('sgst_rate', 5, 2)->default(0);   // e.g. 1.5
        $table->decimal('igst_rate', 5, 2)->default(0);   // e.g. 3.0

        $table->decimal('cgst_amount', 10, 2)->default(0);  // amount * cgst_rate/100
        $table->decimal('sgst_amount', 10, 2)->default(0);  // amount * sgst_rate/100
        $table->decimal('igst_amount', 10, 2)->default(0);  // amount * igst_rate/100

        // ── Gross ─────────────────────────────────────────────
        $table->decimal('gross_amount', 10, 2);  

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tax_details');
    }
};
