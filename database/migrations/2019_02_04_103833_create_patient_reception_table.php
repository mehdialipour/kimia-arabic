<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientReceptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_reception', function (Blueprint $table) {
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('reception_id');

            $table->foreign('reception_id')->references('id')->on('receptions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('patient_id')->references('id')->on('patients')
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
        Schema::dropIfExists('patient_reception');
    }
}
