<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBranchesTable extends Migration
{
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_7600290')->references('id')->on('companies');
            $table->unsignedBigInteger('sub_company_id')->nullable();
            $table->foreign('sub_company_id', 'sub_company_fk_7600291')->references('id')->on('sub_companies');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7600294')->references('id')->on('users');
        });
    }
}
