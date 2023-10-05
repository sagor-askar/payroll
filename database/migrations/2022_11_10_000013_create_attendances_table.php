<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('clock_in');
            $table->time('clock_out')->nullable();
            $table->time('late')->nullable();
            $table->time('early_leaving')->nullable();
            $table->time('total_work')->nullable();
            $table->timestamps();
        });
    }
}
