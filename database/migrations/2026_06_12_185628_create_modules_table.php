<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Ex: "Rapports avancés"
            $table->string('key')->unique();              // Ex: "reports_advanced"
            $table->text('description')->nullable();
            $table->boolean('is_free')->default(true);    // true = inclus dans le plan gratuit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};