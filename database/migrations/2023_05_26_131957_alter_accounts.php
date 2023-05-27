<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->bigInteger('leadid')->nullable();
            $table->bigInteger('ownerid')->change();
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->bigInteger('accountid')->change();
            $table->bigInteger('ownerid')->change();
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->bigInteger('ownerid')->change();
            $table->bigInteger('accountid')->change();
            $table->bigInteger('contactid')->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['leadid']);
          });
    }
};
