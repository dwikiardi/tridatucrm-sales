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
        Schema::create('maintenance_detail', function (Blueprint $table) {
            $table->id();
            $table->string('nomaintenance');
            $table->bigInteger('stockid');
            $table->integer('qty')->nullable()->default(0);
            $table->text('serial')->nullable();
            $table->tinyinteger('status')->nullable()->default(1);//1:used, 2:Unused, 3:Return,  0:reqstock
            $table->string('installed')->nullable();
            $table->string('instaledserial')->nullable();
            $table->integer('installedqty')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_detail');
    }
};
