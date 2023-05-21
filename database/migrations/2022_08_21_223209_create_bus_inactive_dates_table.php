<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_inactive_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id')->index();
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
            $table->string('date');
            $table->enum('status',['A','D'])->default('D');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_inactive_dates');
    }
};
