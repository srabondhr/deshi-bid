<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->string('profile_picture')->nullable();
            $table->string('contact_number')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->string('profile_picture')->nullable();
            $table->string('contact_number')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('profile_picture');
            $table->dropColumn('contact_number');
        });
    }
};
