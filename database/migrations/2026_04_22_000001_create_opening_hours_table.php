<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('day_of_week');
            $table->time('opens_at');
            $table->time('closes_at');
            $table->smallInteger('sort_order')->default(1);
            $table->timestamps();

            $table->index(['day_of_week', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opening_hours');
    }
};
