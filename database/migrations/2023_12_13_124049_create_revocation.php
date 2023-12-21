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
        Schema::create('revocation', function (Blueprint $table) {
            $table->id();
            $table->string('notrans')->nullable();
            $table->date('date')->nullable();//requested install date
            $table->bigInteger('leadid')->nullable();//Lead ID to install
            $table->bigInteger('staffid')->nullable();//staff hwo will install
            $table->bigInteger('ipid')->nullable();//IP ID to install
            $table->bigInteger('pops')->nullable();//POPs hwo will install
            $table->bigInteger('packageid')->nullable();//Lead ID to install
            $table->tinyinteger('status')->default(1);//status : 1->Open; 2->Onproggress; 3->done; 0->canceled
            $table->text('note')->nullable();
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
        Schema::dropIfExists('revocation');
    }
};
