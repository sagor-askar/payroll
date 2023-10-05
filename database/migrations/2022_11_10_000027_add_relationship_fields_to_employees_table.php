<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_7600767')->references('id')->on('departments');
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->foreign('designation_id', 'designation_fk_7600768')->references('id')->on('designations');
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id', 'grade_fk_7600769')->references('id')->on('grades');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7600783')->references('id')->on('users');
        });
    }
}
