<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyHolidaysTable extends Migration
{
    public function up()
    {
        Schema::create('weekly_holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('weeklyleave');
            $table->timestamps();
        });
    }
}
