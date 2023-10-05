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
        Schema::create('interview_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('job_id');
            $table->date('interview_date');
            $table->string('viva_marks');
            $table->string('written_marks');
            $table->string('mcq_marks');
            $table->string('total_marks');
            $table->string('recommandation')->nullable();
            $table->string('interviewer');
            $table->longText('details')->nullable();
            $table->integer('status')->default(0)->comment('0=>Not Selected, 1=> Selected' );
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
        Schema::dropIfExists('interview_results');
    }
};
