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
        Schema::create('providentfund_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->nullable()->comment('0=>inactive;1=>active');
            $table->tinyInteger('company_contribution_status')->nullable()->comment('0=>inactive;1=>active');
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
        Schema::dropIfExists('providentfund_settings');
    }
};
