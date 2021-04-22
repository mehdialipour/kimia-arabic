<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('gender',['male','female']);
            $table->string('national_id', 15)->nullable();
            $table->unsignedInteger('insurance_id');
            $table->string('mobile', 15)->nullable();
            $table->string('phone')->nullable();
            $table->string('birth_year',10);
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('insurance_id')
                  ->references('id')->on('insurances')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
