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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('ot_date')->nullable();
            $table->integer('ot_time')->nullable();
            $table->integer('working_hour')->nullable();
            $table->float('hour_rate',10,2)->nullable();
            $table->float('ot_salary',10,2)->nullable();
            $table->longText('reason')->nullable();
            $table->integer('status')->default(0)->comment('0=>Pending, 1=> Approved, 2=>Rejected');
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('overtimes');
    }
};
