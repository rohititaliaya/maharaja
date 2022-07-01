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
        Schema::create('drop_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->unsignedBigInteger('to')->nullable();
            $table->foreign('to')->references('id')->on('cities');
            $table->text('drop_points');
            $table->string('last_drop');
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
        Schema::dropIfExists('drop_points');
    }
};
