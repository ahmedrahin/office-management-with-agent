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
        Schema::create('tour_package_places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_packages_id')->nullable();
            $table->unsignedBigInteger('tourist_place_id'); 
            $table->foreign('tour_packages_id')->references('id')->on('tour_packages')->onDelete('cascade');
            $table->foreign('tourist_place_id')->references('id')->on('tourist_places')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_package_places');
    }
};
