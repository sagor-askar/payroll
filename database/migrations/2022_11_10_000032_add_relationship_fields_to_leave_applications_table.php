<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLeaveApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_7601113')->references('id')->on('departments');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_7601114')->references('id')->on('companies');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_7601115')->references('id')->on('employees');
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->foreign('leave_type_id', 'leave_type_fk_7601116')->references('id')->on('leave_types');
        });
    }
}
