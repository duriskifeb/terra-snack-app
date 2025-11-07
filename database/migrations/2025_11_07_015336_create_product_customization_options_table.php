<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_customization_options', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('customization_option_id')->constrained('customization_options')->cascadeOnDelete();
            $table->primary(['product_id', 'customization_option_id'], 'prod_cust_option_primary');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_customization_options');
    }
};
