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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid("id_notification")->unique();
            $table->foreignUuid("id_user")->constrained("users", "id_user")->references("id_user")->on("users")->onDelete("NO ACTION");
            $table->foreignUuid("id_record")->constrained("records", "id_record")->references("id_record")->on("records")->onDelete("NO ACTION");
            $table->enum('status', ['apr', 'rej']);
            $table->string('message', 255);
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
