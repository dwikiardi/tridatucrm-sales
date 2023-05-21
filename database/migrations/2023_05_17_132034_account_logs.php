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
        Schema::create('accountlogs', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->integer('moduleid');
            $table->integer('userid');
            $table->string('subject');
            $table->text('prevdata');
            $table->text('newdata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('accountlogs');
    }
};
