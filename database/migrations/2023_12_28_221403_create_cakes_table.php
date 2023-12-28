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
        Schema::create('cakes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255)->nullable(false);
            $table->string('description', 255)->nullable(false);
            $table->decimal('weight')->default(0)->nullable(true);
            $table->decimal('price')->default(0)->nullable(false);
            $table->integer('stock')->default(0)->nullable(false);
            $table->enum('status', ['not available', 'available'])
            ->default('not available')
            ->nullable(false);
            $table->index(['name']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cakes');
    }
};
