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
        Schema::create('vehicle_changes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('plat_number');
            $table->string('type');
            $table->string('max_capacity');
            $table->string('stnk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_changes');
    }
};
