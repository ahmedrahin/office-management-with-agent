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
        Schema::create('tourists', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->text('front_image')->nullable();
            $table->text('back_image')->nullable();
            $table->text('passport_image')->nullable();

            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete()->nullable();
            $table->integer('tourist_place_id')->nullable();
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->string('user_type')->default('admin');
            $table->decimal('processing_fees')->default('0');

            
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourists');
    }
};
