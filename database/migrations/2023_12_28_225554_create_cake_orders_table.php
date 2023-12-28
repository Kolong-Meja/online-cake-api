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
        Schema::create('cake_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cake_id')
            ->references('id')
            ->on('cakes')
            ->cascadeOnDelete();
            $table->foreignUuid('order_id')
            ->references('id')
            ->on('orders')
            ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cake_orders');
    }
};
