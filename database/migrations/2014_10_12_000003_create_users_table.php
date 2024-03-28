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
            $table->foreignId('id_reg')->constrained('regions', 'id');
            $table->foreignId('id_com')->constrained('communes', 'id');
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('dni', 45)->unique();
            $table->string('address')->nullable();
            $table->string('date_reg');
            $table->enum('status', ['A', 'I', 'trash'])->default('A');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
