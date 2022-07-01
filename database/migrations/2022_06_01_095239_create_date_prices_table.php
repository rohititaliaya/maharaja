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
        Schema::create('date_prices', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->integer('price');
            $table->string('route_id');
            $table->integer('seats_avail')->default(38);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_prices');
    }
};
