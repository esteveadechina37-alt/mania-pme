<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Nom de l'entreprise
            $table->string('email')->unique();          // Email officiel
            $table->string('phone')->nullable();        // Téléphone
            $table->string('address')->nullable();      // Adresse
            $table->string('city')->nullable();         // Ville
            $table->string('country')->nullable();      // Pays
            $table->string('sector')->nullable();       // Secteur d'activité
            $table->string('logo')->nullable();         // Logo
            $table->integer('employees_count')->default(0); // Nb employés
            $table->boolean('is_active')->default(true);    // Compte actif ?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};