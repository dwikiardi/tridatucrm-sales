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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contactname');
            $table->integer('ownerid');
            $table->integer('accountid');
            $table->string('email')->nullable();
            $table->string('optemail')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('optmobile')->nullable();
            $table->string('billingaddress')->nullable();
            $table->string('billingcity')->nullable();
            $table->string('billingprovince')->nullable();
            $table->string('billingcountry')->nullable();
            $table->string('billingzipcode')->nullable();
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
        Schema::dropIfExists('contacts');
    }
};
