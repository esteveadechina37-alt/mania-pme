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
        Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
        $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
        $table->string('position')->nullable();
        $table->string('contract_type')->nullable(); // CDI, CDD, Stage...
        $table->decimal('salary', 10, 2)->nullable();
        $table->date('hire_date')->nullable();
        $table->date('contract_end_date')->nullable();
        $table->string('status')->default('active'); // active, suspended, terminated
        $table->timestamps();
        });
        // Schema::create('employees', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
