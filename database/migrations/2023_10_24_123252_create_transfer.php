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
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id');
            $table->date('transfer_date');
            $table->string('from');// gudang: storage; teknisi:technition
            $table->string('to');
            $table->bigInteger('transferdbyid');//User_ID
            $table->bigInteger('recievedbyid');//User_ID
            $table->boolean('transfertype')->default(0);//0: Transfer In; 1: Transfer Out
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
        Schema::dropIfExists('transfer');
    }
};
