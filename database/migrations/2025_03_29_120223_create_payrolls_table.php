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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('num_of_day_work')->default(0);
            $table->decimal('bonus', 10, 2)->default(0.00);
            $table->decimal('overtime', 10, 2)->default(0.00);
            $table->decimal('gross_salary', 10, 2);
            $table->decimal('cash_advance', 10, 2)->default(0.00);
            $table->integer('late_hours')->default(0);
            $table->integer('absent_days')->default(0);
            // $table->decimal('sss_contribution', 10, 2)->default(0.00);
            // $table->decimal('philhealth', 10, 2)->default(0.00);
            $table->decimal('total_deduction', 10, 2);
            $table->decimal('netpay', 10, 2);
            $table->date('payroll_month');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
