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
       Schema::create('payslips', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
        $table->string('month');
        $table->year('year');
        $table->decimal('base_salary', 10, 2)->default(0);
        $table->decimal('bonuses', 10, 2)->default(0);
        $table->decimal('deductions', 10, 2)->default(0);
        $table->decimal('net_salary', 10, 2)->default(0);
        $table->string('pdf_path')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
