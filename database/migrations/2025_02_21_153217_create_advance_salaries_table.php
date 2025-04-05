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
        Schema::create('advance_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('adv_salary')->nullable(); 
            $table->text('description')->nullable();
            $table->string('salary_date')->nullable(); 
            $table->string('salary_month')->nullable(); 
            $table->string('salary_year')->nullable(); 

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('employees_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_salaries');
    }
};
