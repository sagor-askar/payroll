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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('permitted_id')->nullable();
            $table->longText('loan_details')->nullable();
            $table->float('amount',10,2)->nullable();
            $table->float('installment_amount',10,2)->nullable();
            $table->unsignedBigInteger('installment_period')->nullable();
            $table->date('apply_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->integer('status')->default(0)->comment('0=>Pending, 1=> Approved, 2=>Rejected');
            $table->unsignedBigInteger('created_by')->nullable()->comment('Auth user ID');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Auth user ID');
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
        Schema::dropIfExists('loan_applications');
    }
};
