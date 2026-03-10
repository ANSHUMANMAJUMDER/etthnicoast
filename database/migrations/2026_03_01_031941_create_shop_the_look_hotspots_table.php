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
        Schema::create('shop_the_look_hotspots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_the_look_id');
            $table->unsignedBigInteger('product_id');
            $table->float('x_coordinate');
            $table->float('y_coordinate');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_the_look_hotspots');
    }
};
