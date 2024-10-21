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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_record')->unique();
            $table->foreignUuid("id_user")->constrained("users", "id_user")->references("id_user")->on("users")->onDelete("NO ACTION");
            $table->foreignUuid("id_vehicle")->constrained("vehicles", "id_vehicle")->references("id_vehicle")->on("vehicles")->onDelete("NO ACTION");
            $table->string('driver_name');
            $table->enum('service', ['internal', 'external']);
            $table->string('image');
            $table->string('from_address');
            $table->decimal('from_lon', 10, 7);
            $table->decimal('from_lat', 10, 7);
            $table->string('to_address');
            $table->decimal('to_lon', 10, 7);
            $table->decimal('to_lat', 10, 7);
            $table->enum('status', ['new', 'apr', 'rej']);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

            // $table->foreign('id_vehicle')->references('id')->on('vehicles')->onDelete('cascade')->name('fk_bookings_id_vehicle');
            // $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->name('fk_bookings_id_user');
            // $table->foreign('id_driver')->references('id')->on('users')->onDelete('cascade')->name('fk_bookings_id_driver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
