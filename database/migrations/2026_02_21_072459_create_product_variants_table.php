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
        Schema::create('product_variants', function (Blueprint $table) {
               $table->id(); 

            $table->unsignedBigInteger('product_id')
                ->index()->nullable();

            $table->string('product_code')->unique();

            $table->unsignedBigInteger('polish_type_id')
                ->nullable()
                ->index();

            $table->unsignedBigInteger('stone_type_id')
                ->nullable()
                ->index();

            $table->unsignedBigInteger('pearl_type_id')
                ->nullable()
                ->index();
            $table->decimal('quantity', 12, 3)->default(0);
             $table->decimal('base_price', 12, 2)->default(0);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->decimal('cgst', 12, 2)->nullable();
            $table->decimal('sgst', 12, 2)->nullable(); 
            $table->decimal('weight', 12, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
