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
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->float('paid_amount',10,2)->default(0)->nullable();
            $table->float('due_amount',10,2)->default(0)->nullable();
            $table->date('adjustment_date')->after('approved_date')->nullable();
            $table->integer('paid_status')->default(0)->after('approved_date')->comment('0=>Unpaid, 1=> Paid,2=Partial Paid');
            $table->integer('active_status')->default(0)->after('status')->comment('0=>Inactive, 1=> Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            //
        });
    }
};
