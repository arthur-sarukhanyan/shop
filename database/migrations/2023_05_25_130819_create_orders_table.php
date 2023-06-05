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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->unsignedBigInteger('customer_id');
            $table->float('price');
            $table->float('original_price');
            $table->timestamps();

            $table->softDeletes();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
