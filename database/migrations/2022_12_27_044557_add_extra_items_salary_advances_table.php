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
        Schema::table('salary_advances', function (Blueprint $table) {
            $table->integer('paid_status')->default(0)->after('created_by')->comment('0=>Unpaid, 1=> Paid');
            $table->integer('status')->default(0)->after('reason')->comment('0=>Pending, 1=> Approved, 2=>Rejected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_advances', function (Blueprint $table) {
            //
        });
    }
};
