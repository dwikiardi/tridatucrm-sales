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
        Schema::create('installation', function (Blueprint $table) {
            $table->id();
            $table->string('noinstall')->nullable();
            $table->date('date')->nullable();//requested install date
            $table->date('installdate')->nullable();//install date
            $table->bigInteger('leadid')->nullable();//Lead ID to install
            $table->tinyinteger('iptype')->nullable();//0:Static Private IP; 1:Static PublicIP; 2:DynamicIP
            $table->bigInteger('ipid')->nullable();//IPAddress ID to install
            $table->bigInteger('popid')->nullable();//POPs ID to install
            $table->bigInteger('installerid')->nullable();//staff hwo will install
            $table->bigInteger('processbyid')->nullable();//staff hwo do install
            $table->text('note')->nullable();
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
        Schema::dropIfExists('installation');
    }
};
