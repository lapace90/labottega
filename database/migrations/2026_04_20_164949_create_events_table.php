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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Campi traducibili (JSON: {"it": "...", "en": "..."})
            $table->json('slug');
            $table->json('title');
            $table->json('excerpt')->nullable();
            $table->json('description')->nullable();
            $table->json('location_name')->nullable();

            // Campi non traducibili
            $table->string('organizer_name')->nullable();
            $table->string('external_url', 500)->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_published')->default(false);

            $table->timestamps();

            // Indici per performance
            $table->index('starts_at');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
