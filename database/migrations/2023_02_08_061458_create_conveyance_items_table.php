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
        Schema::create('conveyance_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conveyance_id')->nullable();
            $table->longText('description')->nullable();
            $table->longText('from_place')->nullable();
            $table->longText('to_place')->nullable();
            $table->string('mode_of_transport')->nullable();
            $table->float('cost',10,2)->nullable();
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
        Schema::dropIfExists('conveyance_items');
    }
};
