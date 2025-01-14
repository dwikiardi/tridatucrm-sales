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
        Schema::create('datalogs', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->bigInteger('moduleid');
            $table->string('logname')->nullable();
            $table->text('olddata')->nullable();
            $table->text('newdata')->nullable();
            $table->bigInteger('createbyid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datalogs');
    }
};
