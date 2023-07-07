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
        Schema::create('filter_products', function (Blueprint $table) {
            $table->unsignedBigInteger('filter_id');
            $table->unsignedBigInteger('product_id');
        });

        Schema::table('filter_products', function (Blueprint $table) {
            $table->foreign('filter_id')
                ->references('id')
                ->on('filters');

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
        Schema::dropIfExists('filter_products');
    }
};
