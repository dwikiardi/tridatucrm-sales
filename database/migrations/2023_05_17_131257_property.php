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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('propertyname');
            $table->integer('ownerid');
            $table->integer('accountid');
            $table->integer('contactid');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('maplat')->nullable();
            $table->string('maplong')->nullable();
            $table->string('mapurl')->nullable();
            $table->integer('productid')->nullable();
            $table->text('note')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('properties');
    }
};
