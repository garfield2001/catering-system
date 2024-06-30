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
        Schema::create('reservations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('reference_number')->unique();
            $table->ulid('customer_id');
            $table->dateTime('date_of_reservation');
            $table->dateTime('date_of_event');
            $table->integer('duration');
            $table->string('event_type');
            $table->ulid('venue_id');
            $table->integer('number_of_guests');
            $table->decimal('total_cost', 8, 2);
            $table->string('payment_status');
            $table->string('booking_status');
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
