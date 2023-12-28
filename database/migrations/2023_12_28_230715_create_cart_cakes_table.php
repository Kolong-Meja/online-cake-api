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
        Schema::create('cart_cakes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('session_id')
            ->references('id')
            ->on('shopping_sessions')
            ->cascadeOnDelete();
            $table->foreignUuid('cake_id')
            ->references('id')
            ->on('cakes')
            ->cascadeOnDelete();
            $table->integer('quantity')
            ->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_cakes');
    }
};
