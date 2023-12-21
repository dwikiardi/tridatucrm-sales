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
        Schema::create('revocation_detail', function (Blueprint $table) {
            $table->id();
            $table->string('notrans');
            $table->bigInteger('stockid');
            $table->integer('qty')->nullable()->default(0);
            $table->text('serial')->nullable();
            $table->tinyinteger('status')->nullable()->default(1);//0:Revocate, 1:UnRevocate
            $table->string('revserial')->nullable();
            $table->integer('revqty')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revocation_detail');
    }
};
