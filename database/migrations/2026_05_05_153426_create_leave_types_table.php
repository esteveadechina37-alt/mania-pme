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
        Schema::create('leave_types', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
        $table->string('name'); // congé payé, maladie, etc.
        $table->integer('days_allowed')->default(30);
        $table->boolean('paid')->default(true);
        $table->timestamps();
        });
        // Schema::create('leave_types', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
