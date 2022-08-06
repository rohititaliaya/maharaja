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
            $table->tinyInteger('payment_status')->unsigned()->default(0)->after('status')->comment('0=Not Paid,1=Captured,2=Transfered,3=refunded');
            $table->unsignedDecimal('total_amount',8,2)->after('payment_status')->nullable();
            $table->unsignedDecimal('amount_without_tax',8,2)->after('total_amount')->nullable();
            $table->unsignedDecimal('transfered_amount',8,2)->nullable()->after('amount_without_tax');
            $table->unsignedDecimal('refunded_amount',8,2)->nullable()->after('transfered_amount');
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
            $table->dropColumn('payment_status');
            $table->dropColumn('total_amount');
            $table->dropColumn('amount_without_tax');
            $table->dropColumn('transfered_amount');
            $table->dropColumn('refunded_amount');
        });
    }
};
