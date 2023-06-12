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
            $table->float('price',16,2)->default(0);
        });
        Schema::table('stocks', function (Blueprint $table) {
            $table->float('price',16,2)->default(0);
            $table->integer('vendorid')->nullable()->change();
            $table->integer('propertiesid')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price']);
          });
          Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['price']);
          });
    }
};
