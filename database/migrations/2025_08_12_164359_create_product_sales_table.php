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
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->string('customer_name');
            $table->string('customer_number');
            $table->string('customer_address');
            $table->date('sales_date');
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('delivery', 10, 2)->nullable();
            $table->decimal('paid', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales');
    }
};
