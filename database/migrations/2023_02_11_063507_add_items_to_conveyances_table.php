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
        Schema::table('conveyances', function (Blueprint $table) {
            $table->date('conveyance_date')->after('designation_id')->nullable();
            $table->unsignedBigInteger('approved_by')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conveyances', function (Blueprint $table) {
            //
        });
    }
};
