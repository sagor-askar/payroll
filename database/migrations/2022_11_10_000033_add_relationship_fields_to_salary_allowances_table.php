<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSalaryAllowancesTable extends Migration
{
    public function up()
    {
        Schema::table('salary_allowances', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_7601124')->references('id')->on('employees');
        });
    }
}
