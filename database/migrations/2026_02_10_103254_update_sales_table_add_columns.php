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
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->after('amount')->default(0);
            $table->decimal('tax', 12, 2)->after('subtotal')->default(0);
            $table->decimal('discount', 12, 2)->after('tax')->default(0);
            $table->decimal('total_price', 12, 2)->after('discount')->default(0);
            $table->string('customer_name')->after('order_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'tax', 'discount', 'total_price', 'customer_name']);
        });
    }
};
