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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->timestamps();
        });

        DB::table('positions')->insert([
            ['position' => 'CEO'],
            ['position' => 'CFO'],
            ['position' => 'Project Manager'],
            ['position' => 'Web Designer'],
            ['position' => 'Web Developer'],
            ['position' => 'Android Developer'],
            ['position' => 'IOS Developer'],
            ['position' => 'Team Leader'],
            ['position' => 'React Developer'],
            ['position' => 'Angular Developer'],
            ['position' => 'VueJs Developer'],
            ['position' => 'NodeJS Developer'],
            ['position' => 'ASP.Net Developer'],
            ['position' => 'UI / UX Designer'],
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
