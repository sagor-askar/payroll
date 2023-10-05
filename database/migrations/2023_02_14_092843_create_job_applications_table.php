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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->string('name');
            $table->string('email');
            $table->string('gender')->nullable();
            $table->string('phone');
            $table->date('apply_date');
            $table->date('dob');
            $table->string('resume');
            $table->string('image')->nullable();
            $table->string('cover_letter')->nullable();
            $table->integer('status')->default(0)->comment('0=>Pending, 1=> Shortlist, 2=>Interview,3=>Selected,4=>Rejected');
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
        Schema::dropIfExists('job_applications');
    }
};
