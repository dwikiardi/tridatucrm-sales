<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('stocksn');
            $table->integer('productid');
            $table->integer('vendorid')->nullable();
            $table->integer('propertiesid')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('createbyid');
            $table->integer('updatebyid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('stocks');
    }
};
