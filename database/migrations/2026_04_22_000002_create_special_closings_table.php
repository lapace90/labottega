<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('special_closings', function (Blueprint $table) {
            $table->id();
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->string('reason');
            $table->timestamps();

            $table->index('starts_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('special_closings');
    }
};
