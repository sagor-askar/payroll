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

           Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->unsignedBigInteger('training_type_id')->nullable();
            $table->unsignedBigInteger('training_skill_id')->nullable();
            $table->float('cost',10,2)->default(0)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('description')->nullable();
            $table->longText('remarks')->nullable();
            $table->integer('performance')->nullable()->comment('1=>Excellent, 2=> Satisfactory,3=>Average, 4=> Poor,5=>Not Concluded');
            $table->integer('status')->default(0)->comment('0=>Pending, 1=>Approved, 2=> Started, 3=>Completed, 4=>Terminated');
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
        Schema::dropIfExists('trainings');
    }
};
