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
        Schema::create('att_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->dateTime('authDateTime')->nullable();
            $table->date('authDate')->nullable();
            $table->time('authTime')->nullable();
            $table->string('direction')->nullable();
            $table->string('deviceName')->nullable();
            $table->string('deviceSN')->nullable();
            $table->string('personName')->nullable();
            $table->string('cardNo')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable()->comment('0=>Absent;1=>Present');
            $table->unsignedBigInteger('approved_by')->nullable();
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
        Schema::dropIfExists('att_logs');
    }
};
