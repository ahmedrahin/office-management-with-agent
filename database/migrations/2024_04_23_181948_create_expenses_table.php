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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('employees_id')->nullable();
            $table->text('details')->nullable();
            $table->string('amn');
            $table->string('month');
            $table->string('date');
            $table->string('year');
            $table->unsignedBigInteger('user_id');
            $table->text('image')->nullable();
            $table->timestamps();

            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
