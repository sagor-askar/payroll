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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('asset_code')->nullable();
            $table->string('qty')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('warranty_period')->nullable();
            $table->float('unit_price',10,2)->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_address')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('assets');
    }
};
