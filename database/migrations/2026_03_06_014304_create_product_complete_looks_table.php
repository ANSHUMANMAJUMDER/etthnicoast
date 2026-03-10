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
        Schema::create('product_complete_looks', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('product_id');        
            $table->unsignedBigInteger('look_product_id');    
            $table->unsignedTinyInteger('position');         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_complete_looks');
    }
};
