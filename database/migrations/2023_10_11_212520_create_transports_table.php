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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate', 10)->unique();
            $table->unsignedBigInteger('model_id');
            $table->decimal('fuel_tank_capacity', 7, 3);
            $table->decimal('average_fuel', 5, 3);
            $table->decimal('estimated_distance', 12, 3);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('model_id')->references('id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
