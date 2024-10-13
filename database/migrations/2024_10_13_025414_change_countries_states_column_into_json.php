<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // No need to change the countries table anymore, we are dropping it entirely
        // This migration is now focused on adjustments related to the states table (if any needed)
        
        // Example: If you need to make adjustments to the states table, you can do that here
        Schema::table('states', function (Blueprint $table) {
            // No change is required here, but you can add adjustments if needed
            // Example: Adding more columns to states table
        });

        // You can safely drop the countries table here as part of this transition
        Schema::dropIfExists('countries');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If you need to reverse changes, we would need to recreate the countries table if this migration is rolled back
        Schema::create('countries', function (Blueprint $table) {
            $table->string('code', 3)->primary();
            $table->string('name', 255);
            $table->json('states')->nullable();
        });

        // Undo changes to the states table if necessary
        Schema::table('states', function (Blueprint $table) {
            // Example: Drop any new columns that were added
        });
    }
};
