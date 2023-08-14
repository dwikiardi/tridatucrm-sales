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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stockid');
            $table->string('stockcode');
            $table->string('serial')->nullable();
            $table->integer('qty');
            $table->integer('transtype');//1:Pembelian; 2:instalasi; 3:penarikan; 4: returnpembelian; 5:barangrusak;
            $table->string('module');
            $table->bigInteger('moduleid');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('stock_logs');
    }
};
