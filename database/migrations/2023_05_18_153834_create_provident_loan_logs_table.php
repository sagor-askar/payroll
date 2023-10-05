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
        Schema::create('provident_loan_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provident_loan_id')->nullable();
            $table->date('pf_loan_pay_date')->nullable();
            $table->float('pay_amount',10,2)->default(0)->nullable();
            $table->float('due_amount',10,2)->default(0)->nullable();
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
        Schema::dropIfExists('provident_loan_logs');
    }
};
