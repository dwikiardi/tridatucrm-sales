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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->string('nomaintenance')->nullable();
            $table->date('date')->nullable();//requested install date
            $table->date('maintenancedate')->nullable();//install date
            $table->bigInteger('leadid')->nullable();//Lead ID to install
            $table->bigInteger('staffid')->nullable();//staff hwo will install
            $table->text('note')->nullable();
            $table->text('problem')->nullable();
            $table->text('result')->nullable();
            $table->boolean('swap')->default(0);
            $table->boolean('reqstock')->default(0);
            $table->tinyinteger('status')->default(1);//status : 1->Open; 2->Onproggress; 3->done; 0->canceled
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
        Schema::dropIfExists('maintenance');
    }
};
