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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id')->nullable()->after('status');
            $table->string('transfer_id')->nullable()->after('agent_id');
            $table->boolean('transfer_on_hold')->nullable()->after('transfer_id');
            $table->timestamp('transfer_hold_till')->nullable()->after('transfer_on_hold');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('agent_id');
            $table->dropColumn('transfer_id');
            $table->dropColumn('transfer_on_hold');
            $table->dropColumn('transfer_hold_till');
        });
    }
};
