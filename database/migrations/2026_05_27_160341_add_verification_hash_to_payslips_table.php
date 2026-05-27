<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // dans la migration
    public function up()
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->string('verification_hash', 64)->nullable()->unique();
        });
    }
    public function down()
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn('verification_hash');
        });
    }
};
