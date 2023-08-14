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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ordernumbers');
            $table->string('ordername');
            $table->date('orderdate');
            $table->text('note')->nullable();
            $table->bigInteger('vendorid')->nullable();
            $table->tinyInteger('orderstatus')->default(0);// 1: po/order; 2:puechase/pembelian; 3:cancelPO; 4: CancelOrder
            $table->bigInteger('createdbyid')->nullable();
            $table->bigInteger('updatedbyid')->nullable();
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
