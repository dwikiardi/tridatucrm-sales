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
        Schema::create('installationdtl', function (Blueprint $table) {
            $table->id();
            $table->string('noinstall');
            $table->bigInteger('category')->default(1);//Product Category
            $table->bigInteger('stockid');
            $table->string('stockcode')->nullable();
            $table->text('serial')->nullable();
            $table->integer('qty')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(1);//1:dipinjamkan, 0:dijual
            $table->boolean('instaled')->nullable()->default(1);//1:terpasang , 0:tidak
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
        Schema::dropIfExists('installationdtl');
    }
};
