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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meetingname');
            $table->text('location')->nullable();
            $table->boolean('allday')->default(0);
            $table->date('startdate');
            $table->string('starttime');
            $table->date('enddate');
            $table->string('endtime');
            $table->bigInteger('host');
            $table->bigInteger('leadid');
            $table->text('detail')->nullable();;
            $table->text('result')->nullable();;
            $table->boolean('reminder')->default(0);
            $table->integer('remindertime')->nullable();
            $table->bigInteger('createdbyid')->nullable();
            $table->bigInteger('updatedbyid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
