<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id(); // Primary key for the state
            $table->string('code', 5)->unique(); // State code (e.g., "MY-01" for Johor)
            $table->string('name', 255); // State name (e.g., "Johor")
            $table->timestamps();
        });

        // Remove the countries table as requested
        Schema::dropIfExists('countries');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the states table
        Schema::dropIfExists('states');
    }
};
