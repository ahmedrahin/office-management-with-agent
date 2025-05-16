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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('wife_name')->nullable();
            $table->string('village')->nullable();
            $table->string('ward_no')->nullable();
            $table->string('sub_district')->nullable(); // Upazila
            $table->string('district')->nullable();
            $table->string('division')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('nid_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('education_qualification')->nullable();
            $table->string('study_institute')->nullable();
            $table->string('previous_experience')->default('no');
            $table->integer('experience_years')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->string('image')->nullable();
            $table->longText('institute_name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
