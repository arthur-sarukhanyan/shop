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
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('attr_1')->nullable();
            $table->string('attr_2')->nullable();
            $table->unsignedBigInteger('filter_group_id');

            $table->softDeletes();
        });

        Schema::table('filters', function (Blueprint $table) {
            $table->foreign('filter_group_id')
                ->references('id')
                ->on('filter_groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
