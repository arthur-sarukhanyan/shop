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
        Schema::create('customer_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('company_name')->nullable();
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('zip');
            $table->unsignedBigInteger('country_id');
            $table->string('city');
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('customer_details', function (Blueprint $table) {
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_details');
    }
};
