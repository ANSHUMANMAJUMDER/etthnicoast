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
        Schema::create('static_pages', function (Blueprint $table) {
             $table->id();
            $table->string('slug')->unique(); // about-us, why-us, etc.

            // Hero
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_tag')->nullable();         // small label above title
            $table->string('hero_image')->nullable();

            // Generic flexible content (JSON array of sections)
            $table->json('sections')->nullable();

            // Stats / badges (JSON array)
            $table->json('stats')->nullable();

            // CTA
            $table->string('cta_title')->nullable();
            $table->string('cta_subtitle')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_pages');
    }
};
