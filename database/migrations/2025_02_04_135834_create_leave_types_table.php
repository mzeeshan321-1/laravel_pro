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
            $table->string('name')->unique();
            $table->integer('max_days');
            $table->string('year_leave')->nullable();
            $table->boolean('carry_forward')->default(false);
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });

        DB::table('leave_types')->insert([
            ['name' => 'Medical Leave'  ,'max_days'     => '12','year_leave' => date('Y')],
            ['name' => 'Casual Leave'   ,'max_days'     => '12','year_leave' => date('Y')],
            ['name' => 'Sick Leave'     ,'max_days'     => '12','year_leave' => date('Y')],
            ['name' => 'Annual Leave'   ,'max_days'     => '12','year_leave' => date('Y')],
            ['name' => 'Maternity Leave','max_days'     => '12','year_leave' => date('Y')],
            ['name' => 'Paternity Leave','max_days'     => '12','year_leave' => date('Y')],
            ['name' => 'Bereavement Leave','max_days'  => '12','year_leave' => date('Y')],
            ['name' => 'Marriage Leave' ,'max_days'     => '12','year_leave' => date('Y')],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
