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
        Schema::create('basket_items', function (Blueprint $table) {
            $table->id();
            $table->float('quantity');
            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->float('original_price');
            $table->unsignedBigInteger('basket_id');
            $table->unsignedBigInteger('product_id');
        });

        Schema::table('basket_items', function (Blueprint $table) {
            $table->foreign('basket_id')
                ->references('id')
                ->on('baskets')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_items');
    }
};
