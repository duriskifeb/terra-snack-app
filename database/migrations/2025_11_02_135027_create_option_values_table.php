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
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customization_option_id')->constrained('customization_options')->cascadeOnDelete();
            $table->string('name');
            $table->json('details')->nullable();
            $table->decimal('price_modifier', 10, 2)->default(0.00);
            $table->timestamps();
            $table->unique(['customization_option_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_values');
    }
};
