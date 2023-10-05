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
        Schema::create('jobs_creates', function (Blueprint $table) {
            $table->id();
            $table->string('job_title')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->integer('job_type')->nullable()->comment('0=internship,1=parttime,2=fulltime,3=contactual');
            $table->integer('no_of_positions')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('skills')->nullable();
            $table->string('office_time')->nullable();
            $table->string('salary_range')->nullable();
            $table->longText('job_description')->nullable();
            $table->longText('job_requirement')->nullable();
            $table->text('location')->nullable();
            $table->string('need_to_ask')->nullable();
            $table->string('need_to_show_option')->nullable();
            $table->string('custom_question')->nullable();
            $table->integer('circulate_status')->default(0)->comment('1=circulate active,0=circulate inactive');
            $table->integer('approve_status')->default(0)->comment('0=pending,1=approved,2=rejected');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('circulated_by')->nullable();
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
        Schema::dropIfExists('jobs_creates');
    }
};
