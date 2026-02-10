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
            // Make order_id nullable since we're not using orders anymore
            $table->foreignId('order_id')->nullable()->change();
            
            // Add sale number for tracking
            $table->string('sale_number')->unique()->after('id');
            
            // Add table number for restaurant tables
            $table->string('table_number')->nullable()->after('customer_name');
            
            // Add user_id to track which user created the sale
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable(false)->change();
            $table->dropColumn(['sale_number', 'table_number', 'user_id']);
        });
    }
};
