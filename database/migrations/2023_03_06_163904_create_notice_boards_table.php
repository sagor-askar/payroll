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
        Schema::create('notice_boards', function (Blueprint $table) {
            $table->id();  
            $table->unsignedBigInteger('employee_id')->nullable()->comment('0=All Employee');
            $table->unsignedBigInteger('department_id')->nullable()->comment('0=All Department');         
            $table->string('notice_title')->nullable();
            $table->longText('description')->nullable();
            $table->date('notice_date')->nullable();
            $table->tinyInteger('is_seen')->default(0);
            $table->json('seen_users')->nullable();            
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('notice_boards');
    }
};
