<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Ex: "Gratuit", "Standard", "Premium"
            $table->string('slug')->unique();            // Ex: "gratuit", "standard"
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0); // 0 pour gratuit
            $table->enum('billing_period', ['monthly', 'yearly'])->nullable(); // null pour gratuit
            $table->boolean('is_active')->default(true);
            $table->boolean('is_free')->default(false);  // true pour le plan gratuit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};