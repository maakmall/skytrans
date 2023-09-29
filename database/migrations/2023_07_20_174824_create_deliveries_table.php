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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->foreignUuid('company_id');
            $table->string('company_name');
            $table->string('material_code');
            $table->string('material_name');
            $table->string('vehicle_plat_number');
            $table->string('vehicle_type');
            $table->string('vehicle_max_capacity');
            $table->string('driver_name');
            $table->string('driver_contact');
            // $table->foreignUuid('material_id');
            // $table->foreignUuid('vehicle_id');
            // $table->foreignUuid('driver_id');
            $table->string('qr_code')->nullable();
            $table->date('date');
            $table->enum('status', ['Dikirim', 'Diterima'])->default('Dikirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
