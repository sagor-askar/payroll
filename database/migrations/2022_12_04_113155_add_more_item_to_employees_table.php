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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_manual_id')->after('id')->nullable();
            $table->string('employee_device_id')->nullable();
            $table->integer('employee_assign_to_id')->nullable();
            $table->string('emergency_address')->nullable();
            $table->string('nid_no');
            $table->string('passport_no')->nullable();
            $table->float('provident_fund',10,2)->default(0);
            $table->float('marketing_allowance',10,2)->default(0);
            $table->float('mobile_bill',10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
