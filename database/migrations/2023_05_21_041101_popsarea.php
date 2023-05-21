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
        Schema::create('pops', function (Blueprint $table) {
            $table->id();
            $table->string('popname');
            $table->string('area')->nullable();
            $table->string('maplong')->nullable();
            $table->string('maplat')->nullable();
            $table->boolean('status')->default(1);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('pops');
    }
};
