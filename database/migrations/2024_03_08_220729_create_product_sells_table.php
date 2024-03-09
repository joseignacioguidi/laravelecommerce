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
        Schema::create('product_sells', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('idProduct');
            $table->unsignedBigInteger('idSell');
            $table->integer('quantity');
            $table->decimal('individualPrice', 10, 2);
            $table->foreign('idProduct')->references('id')->on('products');
            $table->foreign('idSell')->references('id')->on('sells');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sells');
    }
};
