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
        Schema::create('registations', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->string('email')->nullable();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->enum('gender',['male','female']);
            $table->string('date_of_birth')->nullable();
            $table->string('courses')->nullable();
            $table->string('mobile')->nullable();

            // Permanent Address
            $table->text('permanent_address')->nullable();
            $table->string('permanent_division')->nullable();
            $table->string('permanent_district')->nullable();
            $table->string('permanent_mobile')->nullable();

            // Temporary Address
            $table->text('temporary_address')->nullable();
            $table->string('temporary_division')->nullable();
            $table->string('temporary_district')->nullable();
            $table->string('temporary_mobile')->nullable();

            $table->integer('user_id')->nullable();
            $table->string('emp_name')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registations');
    }
};
