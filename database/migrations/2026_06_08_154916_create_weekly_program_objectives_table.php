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
       Schema::create('weekly_program_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_program_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->float('target')->nullable(); // objectif chiffré (ex: 10)
            $table->float('progress')->nullable()->default(0); // progression actuelle
            $table->enum('status', ['pending', 'in_progress', 'achieved', 'not_achieved'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_program_objectives');
    }
};
