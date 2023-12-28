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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('role_id')
            ->references('id')
            ->on('roles')
            ->cascadeOnDelete();
            $table->string('username', 255)->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->string('email')
            ->unique()
            ->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->rememberToken();
            $table->dateTime('last_login_at')->nullable(true);
            $table->enum('status', ['offline', 'online'])
            ->nullable(false)
            ->default('offline');
            $table->index(['username', 'email']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
