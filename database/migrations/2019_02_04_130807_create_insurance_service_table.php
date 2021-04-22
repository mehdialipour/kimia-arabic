<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_service', function (Blueprint $table) {
            $table->unsignedInteger('insurance_id');
            $table->unsignedInteger('service_id');
            $table->string('tariff');

            $table->foreign('insurance_id')->references('id')->on('insurances')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('service_id')->references('id')->on('services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_service');
    }
}
