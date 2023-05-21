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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->integer('ownerid');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->text('billingaddress')->nullable();
            $table->string('billingcity')->nullable();
            $table->string('billingprovince')->nullable();
            $table->string('billingcountry')->nullable();
            $table->string('billingzipcode')->nullable();
            $table->string('billingemail')->nullable();
            $table->string('billingfax')->nullable();
            $table->string('billingphone')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('accounttype');
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
        Schema::dropIfExists('accounts');
    }
};
