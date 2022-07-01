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
        Schema::create('confirmed_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            // $table->foreign('bus_id')->references('id')->on('buses');
            $table->string('passenger_name');
            $table->string('mobile');
            $table->enum('gender',['M','F','O']);
            $table->string('pickup_point');
            $table->string('drop_point');
            $table->string('pick_time');
            $table->string('drop_time');
            $table->string('age');
            $table->BigInteger('user_id');
            $table->enum('user_type',[1,0]);
            $table->string('seatNo');
            $table->string('from');
            $table->string('to');
            $table->string('date');
            $table->string('total_amount');
            $table->enum('status',[1,0]);
            // $table->enum('cancel_status',[1,0]);
            $table->enum('payment_status',[1,0]);
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
        Schema::dropIfExists('confirmed_seats');
    }
};
