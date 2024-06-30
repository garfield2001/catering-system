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
        Schema::create('equipment_rentals', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('reservation_id');
            $table->string('equipment_type');
            $table->integer('quantity');
            $table->decimal('rental_cost', 8, 2);
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_rentals');
    }
};
