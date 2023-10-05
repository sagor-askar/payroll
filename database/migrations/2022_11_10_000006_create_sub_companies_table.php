<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('sub_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sub_company_name');
            $table->string('sub_company_address');
            $table->string('contact_no')->nullable();
            $table->timestamps();
        });
    }
}
