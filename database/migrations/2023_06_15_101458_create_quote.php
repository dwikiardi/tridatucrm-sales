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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ownerid');
            $table->bigInteger('leadid');
            $table->string('quotenumber')->nullable();
            $table->date('quotedate')->nullable();
            $table->string('quotename')->nullable();
            $table->string('toperson')->nullable();
            $table->text('toaddress')->nullable();
            $table->boolean('approve')->default(0);;
            $table->bigInteger('approvedbyid');
            $table->text('note')->nullable();
            $table->string('attcfile')->nullable();
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
        Schema::dropIfExists('quotes');
    }
};
