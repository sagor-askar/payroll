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
        Schema::table('employees', function (Blueprint $table) {
            $table->tinyInteger('marital_status')->after('gender')->nullable();
            $table->string('spouse')->after('marital_status')->nullable();
            $table->string('spouse_contact_no')->after('spouse')->nullable();
            $table->string('emergency_contact_no')->after('spouse_contact_no')->nullable();
            $table->string('blood_group')->after('emergency_contact_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
