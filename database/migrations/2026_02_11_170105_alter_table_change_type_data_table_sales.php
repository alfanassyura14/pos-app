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
            $table->unsignedBigInteger('amount')->change();
            $table->unsignedBigInteger('subtotal')->change();
            $table->unsignedBigInteger('tax')->change();
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('sale_date');
            $table->dropColumn('total_price');
            $table->unsignedBigInteger('subtotal')->after('discount')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->change();
            $table->decimal('subtotal', 12, 2)->change();
            $table->decimal('tax', 12, 2)->change();
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dateTime('sale_date')->after('id');
            $table->decimal('total_price', 12, 2)->after('tax');
        });
    }
};
