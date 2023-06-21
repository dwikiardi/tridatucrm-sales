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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->date('requestdate')->nullable();//requested survey date
            $table->bigInteger('leadid')->nullable();//Lead ID to survey
            $table->bigInteger('surveyorid')->nullable();//staff hwo do survey
            $table->bigInteger('surveyorto')->nullable();//alocated staff to survey
            $table->string('rmaplat')->nullable();//result Survey Map Latitude
            $table->string('rmaplong')->nullable();//result Survey Map Longitude
            $table->date('surveydate')->nullable();//execute date Survey
            $table->text('surveyresult')->nullable();//Survey Result
            $table->text('note')->nullable();
            $table->string('status')->default('open');//status : Open; Onproggress; done; canceled
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
        Schema::dropIfExists('surveys');
    }
};
