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
        Schema::create('transfer_serial', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id');
            $table->bigInteger('stockid');
            $table->string('stockcode');
            $table->string('serial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_serial');
    }
};
