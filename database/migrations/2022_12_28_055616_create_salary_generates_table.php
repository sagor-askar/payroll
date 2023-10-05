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
        Schema::create('salary_generates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->float('basic_amount',10,2)->default(0);
            $table->float('allowance_amount',10,2)->default(0);
            $table->float('additional_amount',10,2)->default(0);
            $table->float('gross_salary',10,2)->default(0);
            $table->float('loan_amount',10,2)->default(0);
            $table->float('advance_amount',10,2)->default(0);
            $table->float('deduction_amount',10,2)->default(0);
            $table->float('late_deduction_amount',10,2)->default(0);
            $table->float('total_deduction',10,2)->default(0);
            $table->float('net_salary',10,2)->default(0);
            $table->date('generate_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->integer('status')->default(0)->comment('0=>Pending, 1=> Completed');
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
        Schema::dropIfExists('salary_generates');
    }
};
