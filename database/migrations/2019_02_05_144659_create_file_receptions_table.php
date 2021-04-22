<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_receptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_url');
            $table->unsignedInteger('reception_id');
            $table->unsignedInteger('file_type_id');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('reception_id')->references('id')->on('receptions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('file_type_id')->references('id')->on('file_types')
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
        Schema::dropIfExists('file_receptions');
    }
}
