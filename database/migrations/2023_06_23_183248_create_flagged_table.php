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
        Schema::create('flagged_objects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('object_id_user')->nullable();
            $table->foreignId('object_id_character')->nullable();
            $table->foreignId('object_id_guild')->nullable();
            $table->string('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flagged_objects');
    }
};
