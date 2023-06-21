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
        Schema::table('quotes', function (Blueprint $table) {
            $table->integer('status')->default(1); // 1: Waiting For Apporove; 2: Approved; 3:Rejected; 4: Need Revision
            $table->bigInteger('leadid')->nullable()->change(); // 
            $table->date('aprrovedate')->nullable(); // 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['status','aprrovedate']); 
        });
    }
};
