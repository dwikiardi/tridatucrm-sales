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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('stockid',50);
            $table->string('stockname');
            $table->text('desk')->nullable();
            $table->float('sell_price',16,2);
            $table->bigInteger('categoryid');
            $table->boolean('qtytype')->default(0);//0: Qty; 1: SumNoseri
            $table->string('unit');
            $table->bigInteger('createbyid');
            $table->bigInteger('updatebyid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
