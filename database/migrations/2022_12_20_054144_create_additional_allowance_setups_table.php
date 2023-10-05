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
        Schema::create('additional_allowance_setups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('sub_company_id')->nullable();
            $table->string('allowance_name')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=>Active;0=>Inactive');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Auth user id');
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
        Schema::dropIfExists('additional_allowance_setups');
    }
};
