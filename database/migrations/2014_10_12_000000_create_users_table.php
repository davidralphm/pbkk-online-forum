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
            $table->id();
            $table->string('username', 255)->unique();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(0);
            $table->string('signature', 255)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->rememberToken();
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
