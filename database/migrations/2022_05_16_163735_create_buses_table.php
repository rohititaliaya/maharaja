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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('travels_name');
            $table->string('image')->nullable();
            $table->string('plat_no')->nullable();
            $table->integer('seats_avail')->default(38);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->enum('status', ['A','D']);
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
        Schema::dropIfExists('buses');
    }
};
