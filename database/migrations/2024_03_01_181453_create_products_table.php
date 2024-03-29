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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('description',40)->nullable(false);
            $table->unsignedBigInteger('stock')->nullable(false);
            $table->boolean('sale');
            $table->float('priceKG')->nullable(false);
            $table->string('urlImagen')->nullable(false);
            $table->unsignedBigInteger('category_id')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
