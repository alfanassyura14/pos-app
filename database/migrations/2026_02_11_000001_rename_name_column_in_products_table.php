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
        Schema::table('products', function (Blueprint $table) {

            // Rename dulu
            $table->renameColumn('name', 'p_name');
            $table->renameColumn('description', 'p_description');
            $table->renameColumn('price', 'p_price');
            $table->renameColumn('image', 'p_image');
            $table->renameColumn('stock', 'p_stock');
            $table->renameColumn('status', 'p_status');
        });

        // Ubah tipe setelah rename
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('p_price')->change();
            $table->dropColumn('serving');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->renameColumn('p_name', 'name');
            $table->renameColumn('p_description', 'description');
            $table->renameColumn('p_price', 'price');
            $table->renameColumn('p_image', 'image');
            $table->renameColumn('p_stock', 'stock');
            $table->renameColumn('p_status', 'status');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
            $table->string('serving')->nullable();
        });
    }
};
