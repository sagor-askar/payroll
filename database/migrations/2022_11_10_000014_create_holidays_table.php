<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('holiday_name');
            $table->date('from_holiday');
            $table->date('to_holiday');
            $table->integer('number_of_days');
            $table->timestamps();
        });
    }
}
