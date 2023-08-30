<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 16, 2)->default(0);
            $table->decimal('tax', 16, 2)->default(0);
            $table->decimal('shipping', 16, 2)->default(0);
            $table->decimal('total', 16, 2)->default(0);
            $table->string('supno')->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
            'subtotal',
            'tax',
            'shipping',
            'total',
            'supno',
            ]); 
        });
    }
};
