<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->decimal('packaging_fee_per_item', 10, 2)->default(0.00);
            $table->decimal('packaging_fee_total', 10, 2)->default(0.00);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->decimal('gross_amount', 10, 2)->nullable();
            $table->enum('payment_status', ['unpaid', 'pending_verification',  'paid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable(); 
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
