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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ownerid');
            $table->bigInteger('accountid')->nullable();
            $table->string('leadsname')->nullable();
            $table->string('type')->default('lead');// Lead or Contacts
            $table->string('account_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zipcode')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('pic_contact')->nullable();
            $table->string('pic_email')->nullable();
            $table->string('pic_mobile')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('billing_contact')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_mobile')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('property_name')->nullable();
            $table->text('property_address')->nullable();
            $table->string('property_city')->nullable();
            $table->string('property_state')->nullable();
            $table->string('property_zipcode')->nullable();
            $table->string('property_country')->nullable();
            $table->string('maplong')->nullable();
            $table->string('maplat')->nullable();
            $table->string('gmapurl')->nullable();
            $table->string('status')->nullable();
            $table->string('steps')->nullable();
            $table->boolean('active')->default(1);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('leads');
    }
};
