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
        Schema::create('salary_increments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('increment_date')->nullable();
            $table->float('salary',10,2)->nullable();
            $table->integer('increment_percentage')->nullable();
            $table->float('increment_amount',10,2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('Auth user id');
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
        Schema::dropIfExists('salary_increments');
    }
};
