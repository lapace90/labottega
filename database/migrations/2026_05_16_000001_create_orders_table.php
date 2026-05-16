<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->unique();

            $table->string('customer_name', 100);
            $table->string('customer_phone', 30);
            $table->string('customer_email', 150)->nullable();
            $table->text('customer_notes')->nullable();

            $table->string('type', 20)->default('pickup');

            $table->date('slot_date');
            $table->string('slot_time_range', 20);

            $table->string('delivery_address')->nullable();
            $table->string('delivery_zone', 50)->nullable();

            $table->decimal('subtotal', 8, 2);
            $table->decimal('delivery_cost', 8, 2)->default(0);
            $table->decimal('total', 8, 2);

            $table->string('status', 30)->default('pending');

            $table->timestamps();

            $table->index('order_number');
            $table->index(['status', 'slot_date']);
            $table->index('slot_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
