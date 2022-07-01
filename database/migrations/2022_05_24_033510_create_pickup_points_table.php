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
        Schema::create('pickup_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->unsignedBigInteger('from')->nullable();
            $table->foreign('from')->references('id')->on('cities');
            $table->text('pickup_points');  
            $table->string('last_pick');  
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
        Schema::dropIfExists('pickup_points');
    }
};
