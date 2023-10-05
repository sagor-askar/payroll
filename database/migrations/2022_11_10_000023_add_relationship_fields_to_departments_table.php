<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id', 'branch_fk_7600301')->references('id')->on('branches');
            $table->unsignedBigInteger('sub_company_id')->nullable();
            $table->foreign('sub_company_id', 'sub_company_fk_7600302')->references('id')->on('sub_companies');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_7600303')->references('id')->on('companies');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7600305')->references('id')->on('users');
        });
    }
}
