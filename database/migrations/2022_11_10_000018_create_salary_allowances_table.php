<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAllowancesTable extends Migration
{
    public function up()
    {
        Schema::create('salary_allowances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('allowance_name');
            $table->integer('percentage');
            $table->float('percentage_salary', 10, 2)->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('sub_company_id')->nullable();
            $table->timestamps();
        });
    }
}
