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
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade')->default(NULL);
            $table->foreignId('character_id')->nullable()->references('id')->on('characters')->onDelete('cascade')->default(NULL);
            $table->foreignId('guild_id')->nullable()->references('id')->on('guilds')->onDelete('cascade')->default(NULL);
            $table->string('reason')->nullable();
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
