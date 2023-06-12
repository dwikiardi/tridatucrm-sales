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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ownerid');
            $table->string('dealname');
            $table->tinyInteger('dealtype')->default(1);//1: Leads, 2: Accounts
            $table->bigInteger('leadid')->nullable();
            $table->bigInteger('accountid')->nullable();
            $table->bigInteger('contactid')->nullable();
            $table->bigInteger('propertiesid')->nullable();
            $table->bigInteger('productid')->nullable();
            $table->date('date')->nullable();
            $table->float('price',16,2)->default(0);
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
        Schema::dropIfExists('deals');
    }
};
