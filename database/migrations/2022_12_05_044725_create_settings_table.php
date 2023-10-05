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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            $table->string('company_title');
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('company_address');
            $table->string('company_logo')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('prefix')->nullable();
            $table->string('developed_by');

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
        Schema::dropIfExists('settings');
    }
};
